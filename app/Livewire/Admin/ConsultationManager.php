<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $activeTab = 'consulta';
    
    // Consulta fields
    public $diagnosis;
    public $treatment;
    public $notes;
    
    // Receta fields
    public $medicationName = '';
    public $dosage = '';
    public $frequency = '';
    public $prescriptions = [];

    public $pastConsultations = [];
    public $showHistoryModal = false;
    public $showMedicalSummaryModal = false;

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->diagnosis = $appointment->diagnosis;
        $this->treatment = $appointment->treatment;
        $this->notes = $appointment->notes;
        $this->prescriptions = $appointment->prescriptions ?? [];
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function addMedication()
    {
        $this->validate([
            'medicationName' => 'required|string',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
        ]);

        $this->prescriptions[] = [
            'name' => $this->medicationName,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency,
        ];

        $this->reset(['medicationName', 'dosage', 'frequency']);
    }

    public function removeMedication($index)
    {
        unset($this->prescriptions[$index]);
        $this->prescriptions = array_values($this->prescriptions); // Re-index
    }

    public function saveConsultation()
    {
        $this->appointment->update([
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment,
            'notes' => $this->notes,
            'prescriptions' => $this->prescriptions,
            'status' => 2, // Completada
        ]);

        session()->flash('message', 'Consulta guardada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function loadHistory()
    {
        $this->pastConsultations = Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->where('status', 2) // Solo completadas
            ->with('doctor.user')
            ->orderBy('date', 'desc')
            ->get();
            
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
    }

    public function openMedicalSummary()
    {
        $this->showMedicalSummaryModal = true;
    }

    public function closeMedicalSummary()
    {
        $this->showMedicalSummaryModal = false;
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager')->layout('layouts.admin');
    }
}
