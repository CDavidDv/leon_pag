<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\WorkContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class WorkContentController extends Controller
{
    /**
     * Obtener todo el contenido de Work
     */
    public function index()
    {
        $sections = ['logo', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }

        return response()->json(['content' => $content, 'media' => $media]);
    }

    /**
     * Actualizar contenido de texto
     */
    public function updateText(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'content' => 'required|string'
        ]);

        WorkContent::saveContent(
            $request->section,
            $request->field_name,
            $request->content,
            'text'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Actualizar imagen
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240' // 10MB máximo
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/images/work', $filename);
            $url = Storage::url($path);

            WorkContent::saveContent(
                $request->section,
                $request->field_name,
                $url,
                'image'
            );

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo subir la imagen'], 400);
    }

    /**
     * Actualizar enlace
     */
    public function updateLink(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'content' => 'required|url'
        ]);

        WorkContent::saveContent(
            $request->section,
            $request->field_name,
            $request->content,
            'link'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Subir archivo de video
     */
    public function updateVideo(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'video' => 'required|file|mimes:mp4,webm,ogg,avi,mov,wmv|max:102400' // 100MB máximo
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/videos', $filename);
            $url = Storage::url($path);

            WorkContent::saveContent(
                $request->section,
                $request->field_name,
                $url,
                'video'
            );

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo subir el video'], 400);
    }

    /**
     * Actualizar URL de video (YouTube, etc.)
     */
    public function updateVideoUrl(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'content' => 'required|string'
        ]);

        WorkContent::saveContent(
            $request->section,
            $request->field_name,
            $request->content,
            'video_url'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Actualizar URL de imagen
     */
    public function updateImageUrl(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'content' => 'required|string'
        ]);

        WorkContent::saveContent(
            $request->section,
            $request->field_name,
            $request->content,
            'image_url'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Subir archivo multimedia (video o imagen)
     */
    public function updateMedia(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'file' => 'required|file',
            'media_type' => 'required|in:video,image'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mediaType = $request->input('media_type');
            
            // Validar según el tipo de medio
            if ($mediaType === 'video') {
                $request->validate([
                    'file' => 'mimes:mp4,webm,ogg,avi,mov,wmv|max:102400' // 100MB
                ]);
                $path = $file->storeAs('public/videos', time() . '_' . $file->getClientOriginalName());
            } else {
                $request->validate([
                    'file' => 'mimes:jpeg,png,jpg,gif,webp,svg|max:10240' // 10MB
                ]);
                $path = $file->storeAs('public/images/work', time() . '_' . $file->getClientOriginalName());
            }

            $url = Storage::url($path);

            WorkContent::saveContent(
                $request->section,
                $request->field_name,
                $url,
                $mediaType
            );

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo subir el archivo'], 400);
    }

    /**
     * Actualizar contenido de texto para páginas Welcome y Approach
     */
    public function updateTextContent(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'field_name' => 'required|string',
            'content' => 'required|string'
        ]);

        WorkContent::saveContent(
            $request->section,
            $request->field_name,
            $request->content,
            'text'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Obtener contenido de texto para páginas Welcome y Approach
     */
    public function getTextContent()
    {
        $sections = [
            'hero', 'slogan', 'subheading', 'lastslogan', 'problem', 'services', 
            'approach_hero', 'approach_main', 'explore_phase', 'design_phase', 'create_phase', 'work_with_us',
            'layout', 'marketing', 'footer', 'about'
        ];
        $content = [];

        foreach ($sections as $section) {
            $sectionContent = WorkContent::getSectionContent($section);
            $content[$section] = [];
            
            foreach ($sectionContent as $fieldName => $item) {
                $content[$section][$fieldName] = $item->content;
            }
        }

        return response()->json(['success' => true, 'content' => $content]);
    }
}
