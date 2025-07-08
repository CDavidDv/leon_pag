<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteConfig;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Color de fondo por defecto
        SiteConfig::setValue(
            'background_color',
            '#0A15E3',
            'color',
            'Color de fondo principal del sitio'
        );

        // Color primario por defecto
        SiteConfig::setValue(
            'primary_color',
            '#0A15E3',
            'color',
            'Color primario del sitio'
        );

        // Color secundario por defecto
        SiteConfig::setValue(
            'secondary_color',
            '#ffffff',
            'color',
            'Color secundario del sitio'
        );

        // Email de administrador para notificaciones
        SiteConfig::setValue(
            'admin_email',
            'admin@tudominio.com',
            'email',
            'Email de administrador para recibir notificaciones de contacto'
        );
    }
} 