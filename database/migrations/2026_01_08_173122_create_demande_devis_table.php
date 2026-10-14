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
        if (!Schema::hasTable('demande_devis')) {
            Schema::create('demande_devis', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('indicatif')->nullable();
                $table->string('material')->nullable();
                $table->string('category_name')->nullable();
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->string('city')->nullable();
                $table->string('delai_livraison')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_devis');
    }
};
