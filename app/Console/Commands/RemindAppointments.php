<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Services\AppointmentService;

class RemindAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'App:RemindAppointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp para citas en las próximas 24 horas.';

    /**
     * Execute the console command.
     */
    public function handle(AppointmentService $appointmentService): void
    {
        $tomorrow = now()->addDay()->format('Y-m-d');
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $tomorrow)
            ->where('status', '!=', 'cancelled')
            ->whereNull('reminder_sent_at')
            ->get();

        $this->info("Procesando " . $appointments->count() . " recordatorios...");

        foreach ($appointments as $appointment) {
            $dateStr = $appointment->date->format('d/m/Y');
            $timeStr = $appointment->start_time;
            $message = "Your appointment is coming up on {$dateStr} at {$timeStr}.";
            
            $sent = $appointmentService->sendWhatsAppMessage(
                $appointment->patient->user->phone,
                $message,
                'HXb5b62575e6e4ff6129ad7c8efe1f983e', // ContentSid
                ['1' => $dateStr, '2' => $timeStr]     // ContentVariables
            );

            if ($sent) {
                $appointment->update(['reminder_sent_at' => now()]);
                $this->line("Recordatorio enviado a: {$appointment->patient->user->name}");
            } else {
                $this->error("Error enviando a: {$appointment->patient->user->name}");
            }
        }

        $this->info("Proceso finalizado.");
    }
}
