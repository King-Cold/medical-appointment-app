<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyAgendaReport;
use Illuminate\Support\Facades\Log;

class SendDailyDoctorAgendaJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $doctor
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $today = now()->format('Y-m-d');
            
            $appointments = Appointment::where('doctor_id', $this->doctor->id)
                ->whereDate('date', $today)
                ->where('status', '!=', 'cancelled')
                ->orderBy('start_time')
                ->get();

            Mail::to($this->doctor->user->email)
                ->send(new DailyAgendaReport(
                    $this->doctor->user->name,
                    now()->format('d/m/Y'),
                    $appointments
                ));

        } catch (\Exception $e) {
            Log::error("Error enviando agenda diaria al doctor {$this->doctor->id}: " . $e->getMessage());
        }
    }
}
