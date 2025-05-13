<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Rendre un utilisateur administrateur';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilisateur non trouvé avec l'email: {$email}");
            return 1;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("L'utilisateur {$email} est maintenant administrateur.");
        return 0;
    }
} 