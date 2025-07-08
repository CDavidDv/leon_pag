<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #0A15E3;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #0A15E3;
            margin: 15px 0;
        }
        .info-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nuevo mensaje de contacto</h1>
        <p>Has recibido un nuevo mensaje a través del formulario de contacto</p>
    </div>

    <div class="content">
        <div class="info-row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $contactMessage->name }}</span>
        </div>

        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $contactMessage->email }}</span>
        </div>

        <div class="info-row">
            <span class="label">Fecha:</span>
            <span class="value">{{ $contactMessage->created_at->format('d/m/Y H:i:s') }}</span>
        </div>

        <div class="info-row">
            <span class="label">IP:</span>
            <span class="value">{{ $contactMessage->ip_address }}</span>
        </div>

        <div class="message-box">
            <div class="label">Mensaje:</div>
            <div class="value" style="margin-top: 10px; white-space: pre-wrap;">{{ $contactMessage->message }}</div>
        </div>

        <div class="footer">
            <p>Este mensaje fue enviado automáticamente desde el formulario de contacto de tu sitio web.</p>
            <p>Puedes responder directamente a este email para contactar con {{ $contactMessage->name }}.</p>
        </div>
    </div>
</body>
</html> 