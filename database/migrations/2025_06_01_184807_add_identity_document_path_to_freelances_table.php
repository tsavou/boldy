<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('freelances', function (Blueprint $table) {
            $table->string('identity_document_path')->nullable()->after('siret');

        });
    }

    public function down(): void
    {
        Schema::table('freelances', function (Blueprint $table) {
            $table->dropColumn('identity_document_path');
        });
    }
};
