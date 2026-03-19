<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear un usuario de prueba
         User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password'=> bcrypt('12345678'),
            'id_number' => '123456789',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])-> assignRole('Administrador');

    }
}
