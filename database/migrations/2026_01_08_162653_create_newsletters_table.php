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
        if (!Schema::hasTable('newsletters')) {
            Schema::create('newsletters', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // Vérifier et ajouter les colonnes manquantes si nécessaire
            Schema::table('newsletters', function (Blueprint $table) {
                if (!Schema::hasColumn('newsletters', 'email')) {
                    $table->string('email')->unique()->after('id');
                }
                if (!Schema::hasColumn('newsletters', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('email');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
