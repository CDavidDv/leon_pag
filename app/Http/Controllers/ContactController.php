<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactMessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Enviar mensaje de contacto
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Crear el mensaje en la base de datos
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Enviar email de notificación
            $this->sendNotificationEmail($contactMessage);

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar email de notificación
     */
    private function sendNotificationEmail($contactMessage)
    {
        try {
            // Obtener el email de destino desde la configuración del sitio
            $adminEmail = \App\Models\SiteConfig::getValue('admin_email', config('mail.from.address'));
            
            Mail::to($adminEmail)->send(new ContactMessageReceived($contactMessage));
        } catch (\Exception $e) {
            \Log::error('Error enviando email de contacto: ' . $e->getMessage());
        }
    }

    /**
     * Obtener todos los mensajes (para panel de administración)
     */
    public function getMessages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Marcar mensaje como leído
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como leído'
        ]);
    }
}
