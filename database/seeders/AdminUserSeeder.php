<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer ou mettre à jour l'utilisateur administrateur
        User::updateOrCreate(
            ['email' => 'bignondubenin1@gmail.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'), // Mot de passe par défaut : admin123
                'is_admin' => true,
            ]
        );

        $this->command->info('Compte administrateur créé avec succès !');
        $this->command->info('Email: bignondubenin1@gmail.com');
        $this->command->info('Mot de passe par défaut: admin123');
        $this->command->warn('⚠️  IMPORTANT: Changez le mot de passe après la première connexion !');
    }
}
