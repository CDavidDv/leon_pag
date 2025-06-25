<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\WorkContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Subir una nueva imagen y actualizar la base de datos
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB máximo
            'section' => 'required|string',
            'name' => 'required|string',
        ]);

        try {
            $file = $request->file('image');
            $section = $request->input('section');
            $name = $request->input('name');

            // Generar nombre único para el archivo
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Guardar el archivo en storage/app/public/images
            $path = $file->storeAs('images', $fileName, 'public');
            
            // Obtener la URL pública del archivo
            $publicPath = 'images/' . $fileName;

            // Actualizar o crear el registro en la tabla media
            $media = Media::updateOrCreate(
                [
                    'section' => $section,
                    'name' => $name
                ],
                [
                    'type' => 'image',
                    'path' => $publicPath,
                    'description' => 'Imagen actualizada: ' . $file->getClientOriginalName(),
                    'order' => 1
                ]
            );

            // Si es un logo, también actualizar work_contents
            if ($section === 'logo' && $name === 'logo') {
                WorkContent::updateOrCreate(
                    [
                        'section' => 'general',
                        'field_name' => 'logo'
                    ],
                    [
                        'field_type' => 'image',
                        'content' => $publicPath,
                        'order' => 1
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida exitosamente',
                'data' => [
                    'id' => $media->id,
                    'path' => $publicPath,
                    'url' => asset('storage/' . $publicPath),
                    'alt' => $media->description
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subir un nuevo video y actualizar la base de datos
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB máximo
            'section' => 'required|string',
            'name' => 'required|string',
        ]);

        try {
            $file = $request->file('video');
            $section = $request->input('section');
            $name = $request->input('name');

            // Generar nombre único para el archivo
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Guardar el archivo en storage/app/public/videos
            $path = $file->storeAs('videos', $fileName, 'public');
            
            // Obtener la URL pública del archivo
            $publicPath = 'videos/' . $fileName;

            // Actualizar o crear el registro en la tabla media
            $media = Media::updateOrCreate(
                [
                    'section' => $section,
                    'name' => $name
                ],
                [
                    'type' => 'video',
                    'path' => $publicPath,
                    'description' => 'Video actualizado: ' . $file->getClientOriginalName(),
                    'order' => 1
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Video subido exitosamente',
                'data' => [
                    'id' => $media->id,
                    'path' => $publicPath,
                    'url' => asset('storage/' . $publicPath),
                    'alt' => $media->description
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un archivo multimedia
     */
    public function deleteMedia($id)
    {
        try {
            $media = Media::find($id);

            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'Archivo no encontrado'
                ], 404);
            }

            // Eliminar el archivo físico
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }

            // Eliminar el registro de la base de datos
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una imagen (método legacy)
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'name' => 'required|string',
        ]);

        try {
            $section = $request->input('section');
            $name = $request->input('name');

            $media = Media::where('section', $section)
                         ->where('name', $name)
                         ->first();

            if ($media) {
                // Eliminar el archivo físico
                if (Storage::disk('public')->exists($media->path)) {
                    Storage::disk('public')->delete($media->path);
                }

                // Eliminar el registro de la base de datos
                $media->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Imagen eliminada exitosamente'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Imagen no encontrada'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las imágenes de una sección
     */
    public function getSectionImages($section)
    {
        try {
            $images = Media::where('section', $section)
                          ->where('type', 'image')
                          ->orderBy('order')
                          ->get()
                          ->map(function ($image) {
                              return [
                                  'id' => $image->id,
                                  'name' => $image->name,
                                  'path' => $image->path,
                                  'url' => asset('storage/' . $image->path),
                                  'description' => $image->description,
                                  'alt' => $image->description,
                                  'type' => $image->type
                              ];
                          });

            return response()->json([
                'success' => true,
                'data' => $images
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los videos de una sección
     */
    public function getSectionVideos($section)
    {
        try {
            $videos = Media::where('section', $section)
                          ->where('type', 'video')
                          ->orderBy('order')
                          ->get()
                          ->map(function ($video) {
                              return [
                                  'id' => $video->id,
                                  'name' => $video->name,
                                  'path' => $video->path,
                                  'url' => asset('storage/' . $video->path),
                                  'description' => $video->description,
                                  'alt' => $video->description,
                                  'type' => $video->type
                              ];
                          });

            return response()->json([
                'success' => true,
                'data' => $videos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los archivos multimedia de una sección
     */
    public function getSectionMedia($section)
    {
        try {
            $media = Media::where('section', $section)
                         ->orderBy('name')
                         ->orderBy('order')
                         ->get()
                         ->map(function ($item) {
                             return [
                                 'id' => $item->id,
                                 'name' => $item->name,
                                 'path' => $item->path,
                                 'url' => asset('storage/' . $item->path),
                                 'description' => $item->description,
                                 'alt' => $item->description,
                                 'type' => $item->type
                             ];
                         });

            return response()->json([
                'success' => true,
                'data' => $media
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los archivos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener archivos multimedia de un proyecto específico ordenados por índice
     */
    public function getProjectMedia($section)
    {
        try {
            // Obtener imágenes ordenadas por nombre (image_1, image_2, etc.)
            $images = Media::where('section', $section)
                          ->where('type', 'image')
                          ->where('name', 'like', 'image_%')
                          ->orderByRaw('CAST(SUBSTRING(name, 7) AS UNSIGNED)')
                          ->get();

            // Obtener videos ordenados por nombre (video_1, video_2, etc.)
            $videos = Media::where('section', $section)
                          ->where('type', 'video')
                          ->where('name', 'like', 'video_%')
                          ->orderByRaw('CAST(SUBSTRING(name, 7) AS UNSIGNED)')
                          ->get();

            // Combinar y ordenar por índice
            $allMedia = collect();
            
            // Agregar imágenes
            foreach ($images as $image) {
                $index = (int) str_replace('image_', '', $image->name);
                $allMedia->put($index - 1, [
                    'id' => $image->id,
                    'name' => $image->name,
                    'path' => $image->path,
                    'url' => asset('storage/' . $image->path),
                    'description' => $image->description,
                    'alt' => $image->description,
                    'type' => $image->type
                ]);
            }

            // Agregar videos
            foreach ($videos as $video) {
                $index = (int) str_replace('video_', '', $video->name);
                $allMedia->put($index - 1, [
                    'id' => $video->id,
                    'name' => $video->name,
                    'path' => $video->path,
                    'url' => asset('storage/' . $video->path),
                    'description' => $video->description,
                    'alt' => $video->description,
                    'type' => $video->type
                ]);
            }

            // Ordenar por clave (índice) y convertir a array
            $orderedMedia = $allMedia->sortKeys()->values()->toArray();

            return response()->json([
                'success' => true,
                'data' => $orderedMedia
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los archivos del proyecto: ' . $e->getMessage()
            ], 500);
        }
    }
} 