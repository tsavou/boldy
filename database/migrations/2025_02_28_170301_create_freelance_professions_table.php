<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('freelance_professions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freelance_id')->constrained('freelances')->cascadeOnDelete();
            $table->foreignId('profession_id')->constrained('professions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelance_professions');
    }
};
