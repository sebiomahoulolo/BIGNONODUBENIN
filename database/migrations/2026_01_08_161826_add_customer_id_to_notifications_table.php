<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si user_id existe
        $columns = DB::select("SHOW COLUMNS FROM notifications LIKE 'user_id'");
        
        if (!empty($columns)) {
            // Si user_id existe, le rendre nullable
            try {
                DB::statement('ALTER TABLE notifications DROP FOREIGN KEY notifications_user_id_foreign');
            } catch (\Exception $e) {
                // La contrainte n'existe peut-être pas, essayer d'autres noms possibles
                try {
                    $foreignKeys = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = 'notifications' 
                        AND COLUMN_NAME = 'user_id' 
                        AND REFERENCED_TABLE_NAME IS NOT NULL
                    ");
                    if (!empty($foreignKeys)) {
                        DB::statement("ALTER TABLE notifications DROP FOREIGN KEY {$foreignKeys[0]->CONSTRAINT_NAME}");
                    }
                } catch (\Exception $e2) {
                    // Ignorer si la contrainte n'existe pas
                }
            }
            DB::statement('ALTER TABLE notifications MODIFY user_id BIGINT UNSIGNED NULL');
        }
        
        // Vérifier si customer_id existe déjà
        $customerColumns = DB::select("SHOW COLUMNS FROM notifications LIKE 'customer_id'");
        
        if (empty($customerColumns)) {
            // Ajouter customer_id
            Schema::table('notifications', function (Blueprint $table) use ($columns) {
                if (!empty($columns)) {
                    $table->foreignId('customer_id')->nullable()->after('user_id')->constrained('customers')->onDelete('cascade');
                } else {
                    $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Supprimer customer_id
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
        
        // Si user_id existe, le remettre comme non nullable
        $columns = DB::select("SHOW COLUMNS FROM notifications LIKE 'user_id'");
        if (!empty($columns)) {
            DB::statement('ALTER TABLE notifications MODIFY user_id BIGINT UNSIGNED NOT NULL');
            Schema::table('notifications', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
};
