<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\WorkContent;

class CleanupMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar registros existentes
        Media::truncate();
        
        // Actualizar work_contents con rutas correctas
        $this->updateWorkContents();
        
        // Crear nuevos registros de media
        $this->createMediaRecords();
    }

    private function updateWorkContents()
    {
        // Actualizar rutas de imágenes en work_contents
        $imageUpdates = [
            ['section' => 'hero', 'field_name' => 'background_image', 'path' => 'storage/images/hero-bg.svg'],
            ['section' => 'about', 'field_name' => 'image', 'path' => 'storage/images/about-team.svg'],
        ];

        foreach ($imageUpdates as $update) {
            WorkContent::where('section', $update['section'])
                      ->where('field_name', $update['field_name'])
                      ->update(['content' => $update['path']]);
        }
    }

    private function createMediaRecords()
    {
        $mediaData = [
            // Logo
            ['section' => 'logo', 'type' => 'image', 'name' => 'logo', 'path' => 'storage/images/logo.svg', 'description' => 'Logo principal de la empresa', 'order' => 1],
            
            // Imágenes del Hero
            ['section' => 'hero', 'type' => 'image', 'name' => 'background', 'path' => 'storage/images/hero-bg.svg', 'description' => 'Imagen de fondo para la sección hero', 'order' => 1],
            
            
            // Iconos de Servicios
            ['section' => 'services', 'type' => 'image', 'name' => 'web_icon', 'path' => 'storage/images/service-web.svg', 'description' => 'Icono para desarrollo web', 'order' => 1],
            ['section' => 'services', 'type' => 'image', 'name' => 'mobile_icon', 'path' => 'storage/images/service-mobile.svg', 'description' => 'Icono para aplicaciones móviles', 'order' => 2],
            ['section' => 'services', 'type' => 'image', 'name' => 'consulting_icon', 'path' => 'storage/images/service-consulting.svg', 'description' => 'Icono para consultoría IT', 'order' => 3],
            
            // Imagen About
            ['section' => 'about', 'type' => 'image', 'name' => 'team', 'path' => 'storage/images/about-team.svg', 'description' => 'Imagen del equipo de trabajo', 'order' => 1],
            
            // Favicon
            ['section' => 'general', 'type' => 'image', 'name' => 'favicon', 'path' => 'storage/images/favicon.svg', 'description' => 'Favicon del sitio web', 'order' => 2],
        ];

        foreach ($mediaData as $data) {
            Media::create($data);
        }
    }
} 