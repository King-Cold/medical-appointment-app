<?php

namespace App\Services;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    /**
     * Genera un comprobante de cita en PDF.
     */
    public function generateConfirmationPdf(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user']);
        
        $imagePath = public_path('images/ejemplo.png');
        $base64Image = '';
        
        // Solo procesamos la imagen si la extensión GD está instalada
        $gdAvailable = extension_loaded('gd');
        Log::info("Verificando extensión GD: " . ($gdAvailable ? 'Disponible' : 'NO DISPONIBLE'));

        if ($gdAvailable && file_exists($imagePath)) {
            try {
                $imageData = base64_encode(file_get_contents($imagePath));
                $base64Image = 'data:image/png;base64,' . $imageData;
            } catch (\Exception $e) {
                Log::warning("No se pudo procesar la imagen del PDF: " . $e->getMessage());
            }
        }

        $data = [
            'folio' => 'CITA-' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT),
            'patient_name' => $appointment->patient->user->name,
            'patient_email' => $appointment->patient->user->email,
            'patient_phone' => $appointment->patient->user->phone,
            'doctor_name' => $appointment->doctor->user->name,
            'specialty' => $appointment->doctor->specialty,
            'date' => $appointment->date->format('d/m/Y'),
            'time' => $appointment->start_time,
            'end_time' => $appointment->end_time,
            'duration' => $appointment->duration,
            'reason' => $appointment->reason,
            'logo' => $base64Image,
        ];

        return Pdf::loadView('pdf.appointments.confirmation-pdf', $data)->output();
    }

    /**
     * Envía un mensaje de WhatsApp a través de Twilio (Soporta Plantillas de Contenido).
     */
    public function sendWhatsAppMessage(string $phone, string $message, string $contentSid = null, array $variables = null)
    {
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.whatsapp_from');

            if (!$sid || !$token || !$from) {
                Log::warning('Twilio credentials not configured in config/services.php.');
                return false;
            }

            $fromWhatsapp = str_starts_with($from, 'whatsapp:') ? $from : "whatsapp:" . $from;

            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($cleanPhone) == 10) {
                $to = '+521' . $cleanPhone;
            } else {
                $to = str_starts_with($phone, '+') ? $phone : '+' . $phone;
            }
            
            $toWhatsapp = str_starts_with($to, 'whatsapp:') ? $to : "whatsapp:" . $to;

            $payload = [
                'From' => $fromWhatsapp,
                'To' => $toWhatsapp,
            ];

            if ($contentSid) {
                $payload['ContentSid'] = $contentSid;
                if ($variables) {
                    $payload['ContentVariables'] = json_encode($variables);
                }
            } else {
                $payload['Body'] = $message;
            }

            Log::info("Intentando enviar WhatsApp de Twilio:", [
                'from' => $fromWhatsapp,
                'to' => $toWhatsapp,
                'contentSid' => $contentSid,
            ]);

            $response = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", $payload);

            if ($response->successful()) {
                Log::info("WhatsApp enviado exitosamente a {$toWhatsapp}");
                return true;
            }

            Log::error('Twilio API error:', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'to' => $toWhatsapp
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Twilio sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
