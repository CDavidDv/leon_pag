<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteConfig;

class InitializeSiteConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:init-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializar las configuraciones del sitio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Inicializando configuraciones del sitio...');

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

        $this->info('Configuraciones del sitio inicializadas correctamente.');
        
        // Mostrar las configuraciones creadas
        $configs = SiteConfig::all();
        $this->table(['ID', 'Clave', 'Valor', 'Tipo'], $configs->map(function($config) {
            return [$config->id, $config->key, $config->value, $config->type];
        }));
    }
} 