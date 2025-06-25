<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'field_type',
        'field_name',
        'content',
        'order'
    ];

    /**
     * Obtener contenido por sección
     */
    public static function getSectionContent($section)
    {
        return self::where('section', $section)
                   ->orderBy('order')
                   ->get()
                   ->keyBy('field_name');
    }

    /**
     * Guardar o actualizar contenido
     */
    public static function saveContent($section, $fieldName, $content, $fieldType = 'text', $order = 0)
    {
        return self::updateOrCreate(
            [
                'section' => $section,
                'field_name' => $fieldName
            ],
            [
                'field_type' => $fieldType,
                'content' => $content,
                'order' => $order
            ]
        );
    }
}
