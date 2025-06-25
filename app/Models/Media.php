<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'type',
        'name',
        'path',
        'description',
        'order'
    ];

    /**
     * Obtener media por sección
     */
    public static function getSectionMedia($section)
    {
        return self::where('section', $section)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Obtener media por sección y tipo
     */
    public static function getSectionMediaByType($section, $type)
    {
        return self::where('section', $section)
                   ->where('type', $type)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Obtener media por nombre
     */
    public static function getMediaByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * Guardar o actualizar media
     */
    public static function saveMedia($section, $name, $path, $type = 'image', $description = '', $order = 0)
    {
        return self::updateOrCreate(
            [
                'section' => $section,
                'name' => $name
            ],
            [
                'type' => $type,
                'path' => $path,
                'description' => $description,
                'order' => $order
            ]
        );
    }

    /**
     * Obtener la URL completa del archivo
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Verificar si el archivo existe
     */
    public function exists()
    {
        return Storage::disk('public')->exists($this->path);
    }
} 