<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_date')->default(now());
            $table->timestamp('end_date');
            $table->foreignId('freelance_id')->constrained('freelances')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boosts');
    }
};
