<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        // Datos mock para la vista
        $doctors = collect([
            (object)['id' => 1, 'name' => 'Dr. Carlos Perez', 'email' => 'carlos@test.com', 'dni' => '30000001', 'phone' => '333333333', 'specialty' => 'Cardiología'],
            (object)['id' => 2, 'name' => 'Dra. Ana Gomez', 'email' => 'ana@test.com', 'dni' => '30000002', 'phone' => '333333333', 'specialty' => 'Dermatología'],
            (object)['id' => 3, 'name' => 'Dr. Luis Torres', 'email' => 'luis@test.com', 'dni' => '30000003', 'phone' => '333333333', 'specialty' => 'Endocrinología'],
            (object)['id' => 4, 'name' => 'Doctor Demo 1', 'email' => 'doctor1@demo.com', 'dni' => '50000001', 'phone' => '600000001', 'specialty' => 'Ginecología'],
            (object)['id' => 5, 'name' => 'Doctor Demo 2', 'email' => 'doctor2@demo.com', 'dni' => '50000002', 'phone' => '600000002', 'specialty' => 'Geriatría'],
            (object)['id' => 6, 'name' => 'Doctor Demo 3', 'email' => 'doctor3@demo.com', 'dni' => '50000003', 'phone' => '600000003', 'specialty' => 'Hematología'],
            (object)['id' => 7, 'name' => 'Doctor Demo 4', 'email' => 'doctor4@demo.com', 'dni' => '50000004', 'phone' => '600000004', 'specialty' => 'Endocrinología'],
            (object)['id' => 8, 'name' => 'Doctor Demo 5', 'email' => 'doctor5@demo.com', 'dni' => '50000005', 'phone' => '600000005', 'specialty' => 'Cardiología'],
            (object)['id' => 9, 'name' => 'Doctor Demo 6', 'email' => 'doctor6@demo.com', 'dni' => '50000006', 'phone' => '600000006', 'specialty' => 'Endocrinología'],
            (object)['id' => 10, 'name' => 'Doctor Demo 7', 'email' => 'doctor7@demo.com', 'dni' => '50000007', 'phone' => '600000007', 'specialty' => 'Endocrinología'],
        ]);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function schedule($id)
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $hours = [];
        for ($i = 8; $i <= 17; $i++) {
            $formattedHour = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
            $intervals = [];
            for ($m = 0; $m < 60; $m += 15) {
                $start = str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT);
                $endM = $m + 15;
                $endH = $i;
                if ($endM == 60) {
                    $endM = 0;
                    $endH++;
                }
                $end = str_pad($endH, 2, '0', STR_PAD_LEFT) . ':' . str_pad($endM, 2, '0', STR_PAD_LEFT);
                $intervals[] = "$start - $end";
            }
            $hours[$formattedHour] = $intervals;
        }

        return view('admin.doctors.schedule', compact('days', 'hours', 'id'));
    }

    public function edit($id)
    {
        // Mock doctor para el edit
        $doctor = (object)[
            'id' => $id,
            'name' => 'Dr. Carlos Perez',
            'email' => 'carlos@test.com',
            'dni' => '30000001',
            'phone' => '333333333',
            'specialty' => 'Cardiología',
            'status' => 'Activo'
        ];
        
        return view('admin.doctors.edit', compact('doctor'));
    }
}
