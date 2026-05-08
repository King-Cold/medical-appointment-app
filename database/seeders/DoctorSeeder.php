<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si existe el rol Doctor (por si acaso no se ha corrido el RoleSeeder, aunque en el prompt dice que está)
        $user1 = User::create([
            'name' => 'Dr. Carlos Perez',
            'email' => 'carlos@test.com',
            'password' => Hash::make('password'),
            'id_number' => '30000001',
            'phone' => '333333333',
            'address' => 'Hospital Central'
        ]);
        $user1->assignRole('Doctor');
        
        Doctor::create([
            'user_id' => $user1->id,
            'specialty' => 'Cardiología'
        ]);

        $user2 = User::create([
            'name' => 'Dra. Ana Gomez',
            'email' => 'ana@test.com',
            'password' => Hash::make('password'),
            'id_number' => '30000002',
            'phone' => '333333333',
            'address' => 'Clínica San José'
        ]);
        $user2->assignRole('Doctor');

        Doctor::create([
            'user_id' => $user2->id,
            'specialty' => 'Dermatología'
        ]);
        
        $user3 = User::create([
            'name' => 'Dr. Luis Torres',
            'email' => 'luis@test.com',
            'password' => Hash::make('password'),
            'id_number' => '30000003',
            'phone' => '333333333',
            'address' => 'Clínica Santa Fe'
        ]);
        $user3->assignRole('Doctor');

        Doctor::create([
            'user_id' => $user3->id,
            'specialty' => 'Endocrinología'
        ]);
    }
}
