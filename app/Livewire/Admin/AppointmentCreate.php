<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentCreate extends Component
{
    public $date;
    public $specialty = '';
    public $selectedDoctorId = null;
    public $selectedTime = null;
    public $patient_id = '';
    public $reason = '';

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function getDoctorsProperty()
    {
        $query = Doctor::with('user');
        
        if (!empty($this->specialty)) {
            $query->where('specialty', $this->specialty);
        }
        
        return $query->get()->map(function ($doctor) {
            // Generate mock schedule based on doctor ID and date
            $times = [];
            $startHour = 8;
            $endHour = 17;
            
            // Randomize availability based on date string and doctor ID to keep it consistent but pseudo-random
            $seed = crc32($this->date . $doctor->id);
            srand($seed);

            for ($h = $startHour; $h <= $endHour; $h++) {
                for ($m = 0; $m < 60; $m += 15) {
                    if (rand(0, 100) > 40) { // 60% chance to be available
                        $times[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ':00';
                    }
                }
            }
            
            $doctor->available_times = $times;
            return $doctor;
        })->filter(function($doctor) {
            return count($doctor->available_times) > 0;
        });
    }

    public function getPatientsProperty()
    {
        return Patient::with('user')->get();
    }

    public function getSpecialtiesProperty()
    {
        return Doctor::select('specialty')->distinct()->pluck('specialty');
    }

    public function selectTime($doctorId, $time)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedTime = $time;
    }

    public function getSelectedDoctorProperty()
    {
        if (!$this->selectedDoctorId) return null;
        return Doctor::with('user')->find($this->selectedDoctorId);
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'selectedDoctorId' => 'required',
            'selectedTime' => 'required',
            'patient_id' => 'required',
            'reason' => 'nullable|string',
        ]);

        // Logic to save appointment
        // Appointment::create([...])
        
        session()->flash('success', 'Cita creada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.appointment-create', [
            'doctors' => $this->doctors,
            'patients' => $this->patients,
            'specialties' => $this->specialties
        ]);
    }
}
