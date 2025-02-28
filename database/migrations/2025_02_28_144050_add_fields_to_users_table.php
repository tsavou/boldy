<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 100)->after('name');
            //ajouter un champ role_id qui est une clé étrangère vers la table roles et qui a une valeur par défaut de freelance
            $table->foreignId('role_id')->default(2)->after('password')->constrained('roles')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
