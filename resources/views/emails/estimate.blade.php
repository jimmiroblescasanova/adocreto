<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cotización #{{ $quote->id }}</title>
  <style type="text/css">
    /* Estilos generales */
    body {
      margin: 0;
      padding: 0;
      background-color: #f6f6f6;
      font-family: Arial, sans-serif;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    table {
      border-collapse: collapse;
    }
    img {
      border: none;
      display: block;
    }
    /* Contenedor principal */
    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }
    /* Encabezado y pie */
    .header,
    .footer {
      background-color: #555555;
      color: #ffffff;
      text-align: center;
      padding: 20px;
    }
    /* Contenido del correo */
    .content {
      background-color: #ffffff;
      padding: 20px;
      color: #333333;
      font-size: 16px;
      line-height: 1.5;
    }
    /* Botón para el PDF */
    .button {
      background-color: #007bff;
      color: #ffffff !important;
      padding: 10px 20px;
      text-decoration: none;
      display: inline-block;
      border-radius: 5px;
      font-weight: bold;
    }
    /* Estilos para tablas de información */
    .info-table {
      width: 100%;
      margin: 20px 0;
      border: 1px solid #dddddd;
    }
    .info-table td {
      padding: 10px;
      border: 1px solid #dddddd;
    }
    .info-table .label {
      background-color: #f0f0f0;
      font-weight: bold;
      width: 30%;
    }
    /* Responsividad */
    @media only screen and (max-width: 600px) {
      .container {
        width: 100% !important;
      }
    }
  </style>
</head>
<body>
  <table width="100%" bgcolor="#f6f6f6" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table class="container" cellpadding="0" cellspacing="0">
          <!-- Encabezado -->
          <tr>
            <td class="header">
              <h1>Cotización #{{ $quote->id }}</h1>
            </td>
          </tr>
          <!-- Contenido -->
          <tr>
            <td class="content">
              <p>Estimado(a) {{ $quote->entity->name }},</p>
              <p>Gracias por solicitar una cotización. A continuación, encontrará los detalles de su solicitud:</p>
              <table class="info-table" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="label">Fecha</td>
                  <td>{{ $quote->date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                  <td class="label">Total</td>
                  <td>$ {{ number_format($quote->total, 2) }}</td>
                </tr>
                <!-- Puedes agregar más filas según la información requerida -->
              </table>
              <p>Para visualizar o descargar el PDF con la cotización completa, haga clic en el siguiente botón:</p>
              <p style="text-align: center;">
                <a href="{{ route('estimate.pdf', $quote) }}" class="button" target="_blank">Ver Cotización PDF</a>
              </p>
              <p>Si tiene alguna duda o comentario, no dude en contactarnos.</p>
              <p>Saludos cordiales,<br>{{ $quote->company->name }}</p>
            </td>
          </tr>
          <!-- Pie de página -->
          <tr>
            <td class="footer">
              <p>&copy; {{ date('Y') }} {{ $quote->company->name }}. Todos los derechos reservados.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>