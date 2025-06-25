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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // 'hero', 'project_1', 'project_2', etc.
            $table->string('type'); // 'image', 'video', 'audio', 'document', 'other'
            $table->string('name'); // 'logo', 'banner', 'image_1', etc.
            $table->string('path'); // 'images/logo.png', 'images/banner.jpg', etc.
            $table->string('description'); // 'Logo de la empresa', 'Banner de la empresa', etc.
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
