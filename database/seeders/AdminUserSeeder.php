<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin par défaut
        User::create([
            'name' => 'Admin Mantouji',
            'email' => 'admin@mantouji.ma',
            'password' => Hash::make('admin123'), // À changer en production
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        // Créer un utilisateur client de test
        User::create([
            'name' => 'Client Test',
            'email' => 'client@test.ma',
            'password' => Hash::make('client123'),
            'role' => User::ROLE_CLIENT,
            'is_active' => true,
        ]);
    }
}
