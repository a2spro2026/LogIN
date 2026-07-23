<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habillements', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->string('video_path')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habillements');
    }
};
