<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;
use Illuminate\Support\Facades\Log;

class ProcessAppointmentConfirmation implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $appointment
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AppointmentService $appointmentService): void
    {
        try {
            // 1. Generar PDF
            $pdfContent = $appointmentService->generateConfirmationPdf($this->appointment);

            // 2. Enviar Email al Paciente
            try {
                Mail::to($this->appointment->patient->user->email)
                    ->send(new AppointmentConfirmed($this->appointment, $pdfContent));
            } catch (\Exception $e) {
                Log::error("Error enviando email al paciente {$this->appointment->id}: " . $e->getMessage());
            }

            // Pequeña pausa para evitar el límite de "emails por segundo" de Mailtrap (Plan gratuito)
            sleep(2);

            // 3. Enviar Email al Doctor
            try {
                Mail::to($this->appointment->doctor->user->email)
                    ->send(new AppointmentConfirmed($this->appointment, $pdfContent));
            } catch (\Exception $e) {
                Log::error("Error enviando email al doctor {$this->appointment->id}: " . $e->getMessage());
            }

            // 4. Enviar WhatsApp al Paciente
            $whatsappSent = false;
            try {
                $dateStr = $this->appointment->date->format('d/m/Y');
                $timeStr = $this->appointment->start_time;
                $message = "Your appointment is coming up on {$dateStr} at {$timeStr}.";
                
                $whatsappSent = $appointmentService->sendWhatsAppMessage(
                    $this->appointment->patient->user->phone,
                    $message,
                    'HXb5b62575e6e4ff6129ad7c8efe1f983e', // ContentSid
                    ['1' => $dateStr, '2' => $timeStr]     // ContentVariables
                );
            } catch (\Exception $e) {
                Log::error("Error enviando WhatsApp de cita {$this->appointment->id}: " . $e->getMessage());
            }

            // 5. Notificar al Administrador con la agenda actualizada de ese día
            Log::info("Intentando disparar reporte síncrono al administrador...");
            try {
                SendAdminDailyReportJob::dispatchSync($this->appointment->date->format('Y-m-d'));
            } catch (\Exception $e) {
                Log::error("Error encolando reporte para admin: " . $e->getMessage());
            }

            // 6. Actualizar estado de notificación
            $this->appointment->update([
                'notified_at' => now(),
                'whatsapp_sent' => $whatsappSent,
            ]);

        } catch (\Exception $e) {
            Log::error("Error crítico en ProcessAppointmentConfirmation para cita {$this->appointment->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
