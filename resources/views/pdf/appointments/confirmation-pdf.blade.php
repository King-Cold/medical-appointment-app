<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita - Healthify</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; color: #1a202c; margin: 0; padding: 0; background-color: #f8fafc; }
        
        .header-banner { background: #4a90e2; background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); padding: 50px 40px; color: white; text-align: left; }
        .header-banner h1 { margin: 0; font-size: 32px; font-weight: bold; letter-spacing: -0.5px; }
        .header-banner p { margin: 10px 0 0; opacity: 0.9; font-size: 16px; font-weight: 300; }
        .logo { position: absolute; right: 40px; top: 40px; width: 90px; height: 90px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3); background-color: white; }

        .container { padding: 40px; position: relative; margin-top: -30px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; margin-bottom: 25px; border-top: 5px solid #4a90e2; }

        .folio-strip { display: block; background-color: #ebf4ff; color: #2b6cb0; padding: 10px 20px; border-radius: 6px; font-weight: bold; font-size: 18px; margin-bottom: 30px; text-align: right; }
        .folio-strip span { font-size: 12px; font-weight: normal; color: #4a5568; margin-right: 10px; }

        .grid { width: 100%; border-collapse: collapse; }
        .grid td { padding: 15px 0; border-bottom: 1px solid #edf2f7; vertical-align: top; }
        .grid tr:last-child td { border-bottom: none; }
        
        .label { width: 180px; font-size: 11px; font-weight: bold; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 18px; }
        .value { font-size: 16px; color: #2d3748; font-weight: 500; }
        .value-sub { font-size: 13px; color: #a0aec0; display: block; margin-top: 4px; }

        .info-cards { width: 100%; margin-top: 20px; }
        .info-cards td { width: 50%; padding-right: 20px; }

        .footer { position: fixed; bottom: 0; width: 100%; background-color: #2d3748; padding: 25px 40px; color: #cbd5e0; font-size: 11px; text-align: left; }
        .footer b { color: white; }
        .footer-logo { position: absolute; right: 40px; bottom: 20px; color: white; font-weight: bold; font-size: 18px; opacity: 0.5; }

        .badge { display: inline-block; padding: 4px 12px; background-color: #e2e8f0; color: #4a5568; border-radius: 4px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header-banner">
        <h1>Healthify</h1>
        <p>Centro Médico Rodrigo Chi & Asociados</p>
        {{-- @if($logo)
            <img src="{{ $logo }}" class="logo">
        @endif --}}
    </div>

    <div class="container">
        <div class="card">
            <div class="folio-strip">
                <span>ID DE SEGUIMIENTO:</span> {{ $folio }}
            </div>

            <div style="font-size: 22px; font-weight: bold; margin-bottom: 25px; color: #2d3748;">
                Confirmación de Cita Médica
            </div>

            <table class="grid">
                <tr>
                    <td class="label">Información del Paciente</td>
                    <td class="value">
                        {{ $patient_name }}
                        <span class="value-sub">Email: {{ $patient_email }} | Tel: {{ $patient_phone }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Médico y Especialidad</td>
                    <td class="value">
                        Dr. {{ $doctor_name }}
                        <span class="value-sub">Especialidad: {{ $specialty }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Fecha y Horario</td>
                    <td class="value">
                        {{ $date }}
                        <span class="value-sub">Inicia: {{ $time }} | Termina: {{ $end_time ?? 'N/A' }} ({{ $duration ?? '30' }} min)</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Motivo de Consulta</td>
                    <td class="value">{{ $reason }}</td>
                </tr>
            </table>

            <div style="margin-top: 30px; padding: 20px; background-color: #fffaf0; border-radius: 8px; border: 1px solid #feebc8;">
                <p style="margin: 0; font-size: 13px; color: #744210; line-height: 1.5;">
                    <b>INSTRUCCIONES PARA EL PACIENTE:</b><br>
                    Favor de presentarse con este comprobante (digital o impreso) 15 minutos antes de su cita. En caso de no poder asistir, le agradecemos cancelar con al menos 24 horas de anticipación.
                </p>
            </div>
        </div>
    </div>

    <div class="footer">
        <b>Centro Médico Rodrigo Chi</b><br>
        Calle 60 #497, Centro, Mérida, Yucatán, CP 97000<br>
        Teléfono: (999) 543-0285 | Email: contacto@rodrigochi.com
        <div class="footer-logo">Healthify</div>
    </div>
</body>
</html>
