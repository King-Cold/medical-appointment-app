<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Doctor;

class DoctorSchedule extends Component
{
    public $doctor;
    public $schedule = [];
    public $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    public $hours = [];

    public function mount($id)
    {
        $this->doctor = Doctor::findOrFail($id);
        $this->schedule = $this->doctor->schedule ?? [];
        
        // Inicializar horas
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
            $this->hours[$formattedHour] = $intervals;
        }
    }

    public function save()
    {
        $this->doctor->update([
            'schedule' => $this->schedule
        ]);

        session()->flash('success', 'Horario actualizado correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule');
    }
}
