<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #2d3748; line-height: 1.6; background-color: #f7fafc; margin: 0; padding: 0; }
        .wrapper { width: 100%; background-color: #f7fafc; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .header { background-color: #4a90e2; padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
        .content { padding: 40px; }
        .content h2 { color: #2d3748; font-size: 20px; margin-top: 0; }
        .details-box { background-color: #edf2f7; padding: 20px; border-radius: 6px; margin: 20px 0; }
        .details-box p { margin: 8px 0; font-size: 15px; }
        .details-label { font-weight: bold; color: #4a5568; width: 100px; display: inline-block; }
        .footer { padding: 20px; text-align: center; color: #a0aec0; font-size: 13px; background-color: #f7fafc; }
        .button { display: inline-block; padding: 12px 24px; background-color: #4a90e2; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Healthify</h1>
            </div>
            <div class="content">
                <h2>Confirmación de Cita Médica</h2>
                <p>Hola <strong>{{ $name }}</strong>,</p>
                <p>Tu cita ha sido confirmada exitosamente. A continuación encontrarás los detalles de tu próxima visita:</p>
                
                <div class="details-box">
                    <p><span class="details-label">Doctor:</span> {{ $doctor }}</p>
                    <p><span class="details-label">Fecha:</span> {{ $date }}</p>
                    <p><span class="details-label">Hora:</span> {{ $time }}</p>
                </div>

                <p>Hemos adjuntado un comprobante en PDF con esta información para tus registros.</p>
                <p>Te recomendamos llegar 15 minutos antes de la hora programada.</p>
                
                <p style="margin-top: 30px;">Atentamente,<br><strong>El equipo de Healthify</strong></p>
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} Centro Médico Rodrigo Chi. Todos los derechos reservados.</p>
                <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            </div>
        </div>
    </div>
</body>
</html>
