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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // 'hero', 'project_1', 'project_2', etc.
            $table->string('field_type'); // 'text', 'image', 'link'
            $table->string('field_name'); // 'title', 'description', 'link', 'image_1', etc.
            $table->string('link'); // El contenido del campo
            $table->integer('order')->default(0); // Para mantener el orden
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
