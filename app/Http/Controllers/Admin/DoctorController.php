<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = \App\Models\Doctor::with('user')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dni' => 'required|string|unique:users,id_number',
            'phone' => 'nullable|string',
            'specialty' => 'required|string',
        ]);

        \DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make('password'), // Contraseña por defecto
                'id_number' => $request->dni,
                'phone' => $request->phone,
            ]);

            $user->assignRole('Doctor');

            \App\Models\Doctor::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty,
            ]);
        });

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor creado exitosamente.');
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
                $end = str_pad($endH, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m + 15 == 60 ? '00' : str_pad($endM, 2, '0', STR_PAD_LEFT), 2, '0', STR_PAD_LEFT);
                $intervals[] = "$start - $end";
            }
            $hours[$formattedHour] = $intervals;
        }

        return view('admin.doctors.schedule', compact('days', 'hours', 'id'));
    }

    public function edit($id)
    {
        $doctor = \App\Models\Doctor::with('user')->findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'dni' => 'required|string|unique:users,id_number,' . $doctor->user_id,
            'phone' => 'nullable|string',
            'specialty' => 'required|string',
        ]);

        \DB::transaction(function () use ($request, $doctor) {
            $doctor->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'id_number' => $request->dni,
                'phone' => $request->phone,
            ]);

            $doctor->update([
                'specialty' => $request->specialty,
            ]);
        });

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor actualizado exitosamente.');
    }
}
