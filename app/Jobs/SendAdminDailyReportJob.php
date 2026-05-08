<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminDailyReport;
use Illuminate\Support\Facades\Log;

class SendAdminDailyReportJob implements ShouldQueue
{
    use Queueable;

    public $date;

    public function __construct($date = null)
    {
        $this->date = $date ?? now()->format('Y-m-d');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $date = $this->date;
            Log::info("Iniciando generación de reporte para Admin. Fecha: $date");
            
            $appointments = Appointment::with(['doctor.user', 'patient.user'])
                ->whereDate('date', $date)
                ->orderBy('start_time')
                ->get();

            if ($appointments->isEmpty()) {
                return;
            }

            // Asumiendo que el admin tiene un email fijo o lo obtenemos de config
            $adminEmail = config('mail.admin_address', 'chirodrigo497@gmail.com');

            $displayDate = \Carbon\Carbon::parse($date)->format('d/m/Y');

            Mail::to($adminEmail)
                ->send(new AdminDailyReport(
                    $displayDate,
                    $appointments
                ));
            
            Log::info("Reporte para Admin enviado exitosamente a: $adminEmail");

        } catch (\Exception $e) {
            Log::error("Error enviando reporte diario al administrador: " . $e->getMessage());
        }
    }
}
