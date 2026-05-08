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
        $doctor = \App\Models\Doctor::with('user')->findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }
}
