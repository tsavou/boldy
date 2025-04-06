<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelances', function (Blueprint $table) {
            $table->id();
            $table->text('bio');
            $table->integer('price_per_day');
            $table->string('location');
            $table->string('profile_picture')->nullable();
            $table->string('cover_picture')->nullable();
            $table->string('siret', 14)->unique();
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelances');
    }
};
