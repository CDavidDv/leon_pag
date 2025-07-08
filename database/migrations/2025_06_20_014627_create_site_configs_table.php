<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'background_color', 'primary_color', etc.
            $table->text('value'); // El valor de la configuración
            $table->string('type')->default('string'); // 'string', 'color', 'number', 'boolean'
            $table->string('description')->nullable(); // Descripción de la configuración
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_configs');
    }
};
