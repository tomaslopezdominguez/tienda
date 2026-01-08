<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole  = Role::where('slug', 'user')->first();

        if (!$adminRole || !$userRole) {
            $this->command->error("Los roles no existen. Ejecuta primero RoleSeeder.");
            return;
        }

        // ---- ADMIN ----
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Administrador',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
            ]
        );

        $adminUser->roles()->sync([$adminRole->id]);

        // ---- USUARIO NORMAL ----
        $standardUser = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'              => 'Usuario Estándar',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
            ]
        );

        $standardUser->roles()->sync([$userRole->id]);

        $this->command->info("Usuarios creados correctamente.");
    }
}