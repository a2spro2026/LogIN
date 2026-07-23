<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'directeur.general@login.com'],
            [
                'name' => 'Directeur Général',
                'role' => 'superadmin',
                'password' => 'password',
            ]
        );

        // Supprime l'ancien compte superadmin s'il existe
        User::where('email', 'zerraguiabdelilah@login.com')->delete();

    }
}
