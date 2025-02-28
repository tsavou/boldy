<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('freelance_media', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image','video']);
            $table->string('url');
            $table->foreignId('freelance_id')->constrained('freelances')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelance_media');
    }
};
