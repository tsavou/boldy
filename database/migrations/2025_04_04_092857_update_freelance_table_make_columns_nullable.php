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
        Schema::table('freelances', function (Blueprint $table) {
            $table->text('bio')->nullable()->change();
            $table->integer('price_per_day')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('siret')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('freelances', function (Blueprint $table) {
            $table->text('bio')->nullable(false)->change();
            $table->integer('price_per_day')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->string('siret')->nullable(false)->change();
        });
    }
};
