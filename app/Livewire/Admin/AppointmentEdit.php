<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentEdit extends Component
{
    public Appointment $appointment;
    public $date;
    public $specialty = '';
    public $selectedDoctorId = null;
    public $selectedTime = null;
    public $patient_id = '';
    public $reason = '';

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->date = $appointment->date->format('Y-m-d');
        $this->selectedDoctorId = $appointment->doctor_id;
        $this->selectedTime = $appointment->start_time;
        $this->patient_id = $appointment->patient_id;
        $this->reason = $appointment->reason;
        $this->specialty = $appointment->doctor->specialty;
    }

    public function getDoctorsProperty()
    {
        $query = Doctor::with('user');
        
        if (!empty($this->specialty)) {
            $query->where('specialty', $this->specialty);
        }
        
        $dayOfWeek = Carbon::parse($this->date)->locale('es')->dayName;
        $dayOfWeek = ucfirst($dayOfWeek);

        return $query->get()->map(function ($doctor) use ($dayOfWeek) {
            $times = [];
            $schedule = $doctor->schedule ?? [];
            
            if (isset($schedule[$dayOfWeek])) {
                foreach ($schedule[$dayOfWeek] as $interval => $isAvailable) {
                    if ($isAvailable) {
                        $startTime = explode(' - ', $interval)[0] . ':00';
                        $times[] = $startTime;
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

        $endTime = Carbon::parse($this->selectedTime)->addMinutes(15)->format('H:i:s');

        $this->appointment->update([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->selectedDoctorId,
            'date' => $this->date,
            'start_time' => $this->selectedTime,
            'end_time' => $endTime,
            'reason' => $this->reason,
        ]);
        
        session()->flash('success', 'Cita actualizada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.appointment-create', [ // Reuse the same view if possible or create a new one
            'doctors' => $this->doctors,
            'patients' => $this->patients,
            'specialties' => $this->specialties
        ]);
    }
}
