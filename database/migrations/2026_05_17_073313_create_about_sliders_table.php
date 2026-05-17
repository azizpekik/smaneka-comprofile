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
        Schema::create('about_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // Path gambar
            $table->string('caption')->nullable(); // Caption minimalis
            $table->string('link')->nullable(); // URL link
            $table->integer('order')->default(0); // Urutan slide
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sliders');
    }
};
