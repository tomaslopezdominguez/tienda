<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // El orden es importante:
        // 1. Roles (para que existan en la BD)
        // 2. Usuarios (para que puedan ser asociados a un Rol)
        $this->call([
            RoleSeeder::class,       // Crea los roles 'admin' y 'user'
            // Ahora llama a UserSeeder.php, que contiene la lógica para crear y asignar roles.
            UserSeeder::class, 
        ]);
    }
}