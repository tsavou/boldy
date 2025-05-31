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
            $table->dropColumn('portfolio_url');
            $table->dropColumn('linkedin_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('freelances', function (Blueprint $table) {
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();
        });
    }
};
