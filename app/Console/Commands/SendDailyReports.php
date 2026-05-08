<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Doctor;
use App\Jobs\SendAdminDailyReportJob;
use App\Jobs\SendDailyDoctorAgendaJob;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'App:SendDailyReports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispara los reportes diarios para Administradores y Doctores.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Iniciando generación de reportes diarios...");

        // 1. Reporte para el Administrador
        SendAdminDailyReportJob::dispatch();
        $this->line("Trabajo de reporte de Administrador encolado.");

        // 2. Reportes para cada Doctor con citas hoy
        $doctors = Doctor::whereHas('appointments', function ($query) {
            $query->whereDate('date', now()->format('Y-m-d'))
                  ->where('status', '!=', 'cancelled');
        })->get();

        $this->info("Encolando reportes para " . $doctors->count() . " doctores...");

        foreach ($doctors as $doctor) {
            SendDailyDoctorAgendaJob::dispatch($doctor);
            $this->line("Reporte encolado para el Dr. {$doctor->user->name}");
        }

        $this->info("Proceso de reportes finalizado.");
    }
}
