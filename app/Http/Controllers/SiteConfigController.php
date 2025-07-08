<?php

namespace App\Http\Controllers;

use App\Models\SiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller
{
    /**
     * Obtener todas las configuraciones del sitio
     */
    public function index()
    {
        $configs = SiteConfig::all()->pluck('value', 'key');
        return response()->json(['success' => true, 'data' => $configs]);
    }

    /**
     * Obtener una configuración específica
     */
    public function show($key)
    {
        $value = SiteConfig::getValue($key);
        return response()->json(['success' => true, 'data' => $value]);
    }

    /**
     * Actualizar una configuración
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'value' => 'required|string',
            'type' => 'sometimes|string',
            'description' => 'sometimes|string'
        ]);

        $config = SiteConfig::setValue(
            $key,
            $request->value,
            $request->type ?? 'string',
            $request->description
        );

        return response()->json([
            'success' => true,
            'data' => $config,
            'message' => 'Configuración actualizada correctamente'
        ]);
    }

    /**
     * Obtener el color de fondo
     */
    public function getBackgroundColor()
    {
        $backgroundColor = SiteConfig::getValue('background_color', '#0A15E3');
        
        return response()->json([
            'success' => true,
            'data' => $backgroundColor,
            'message' => 'Color de fondo obtenido correctamente'
        ]);
    }

    /**
     * Actualizar el color de fondo
     */
    public function updateBackgroundColor(Request $request)
    {
        $request->validate([
            'background_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i'
        ]);

        $config = SiteConfig::setValue(
            'background_color',
            $request->background_color,
            'color',
            'Color de fondo principal del sitio'
        );

        return response()->json([
            'success' => true,
            'data' => $config,
            'message' => 'Color de fondo actualizado correctamente'
        ]);
    }
}
