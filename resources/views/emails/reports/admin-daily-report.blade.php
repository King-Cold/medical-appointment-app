<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #2d3748; line-height: 1.6; background-color: #f7fafc; margin: 0; padding: 0; }
        .wrapper { width: 100%; background-color: #f7fafc; padding: 40px 0; }
        .container { max-width: 800px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .header { background-color: #1a202c; padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 22px; }
        .content { padding: 40px; }
        .content h2 { color: #2d3748; font-size: 18px; border-bottom: 2px solid #edf2f7; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background-color: #f8fafc; color: #4a5568; font-weight: 600; text-align: left; padding: 12px; border-bottom: 2px solid #edf2f7; }
        td { padding: 12px; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        .status-badge { padding: 4px 8px; border-radius: 9999px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-confirmed { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .footer { padding: 20px; text-align: center; color: #a0aec0; font-size: 12px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Reporte General de Actividad</h1>
            </div>
            <div class="content">
                <p>Estimado Administrador,</p>
                <p>A continuación se presenta el consolidado de citas para el día de hoy, <strong>{{ $date }}</strong>:</p>

                @if(count($appointments) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Doctor</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td><strong>{{ $appointment->start_time }}</strong></td>
                            <td>{{ $appointment->doctor->user->name }}</td>
                            <td>{{ $appointment->patient->user->name }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div style="text-align: center; padding: 30px; color: #718096;">
                    <p>No se registran citas programadas para el día de hoy.</p>
                </div>
                @endif
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} Healthify - Panel de Control Administrativo</p>
            </div>
        </div>
    </div>
</body>
</html>
