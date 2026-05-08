<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Recordatorio de citas (Cada hora para verificar citas del día siguiente)
Schedule::command('App:RemindAppointments')
    ->daily();

// Reportes matutinos a las 8:00 AM (Zona horaria de Mérida)
Schedule::command('App:SendDailyReports')
    ->dailyAt('08:00')
    ->timezone('America/Merida');
