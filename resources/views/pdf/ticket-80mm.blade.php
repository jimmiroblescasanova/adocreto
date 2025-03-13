<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket de Venta</title>
  <style type="text/css">
    /* Reset básico */
    body, h1, h2, h3, p, div, table, tr, th, td {
      margin: 0;
      padding: 0;
      border: 0;
    }
    @page { margin: 5px; }
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
    }
    /* Contenedor principal ajustado a 80mm de ancho */
    .ticket-container {
      width: 90%;
      padding: 5mm;
      margin: 0 auto;
    }
    /* Encabezado del ticket */
    .ticket-header {
      text-align: center;
      margin-bottom: 5mm;
    }
    .ticket-header h1 {
      font-size: 16px;
      margin-bottom: 3mm;
    }
    .ticket-header p {
      font-size: 12px;
      line-height: 1.2;
    }
    /* Detalles de la venta */
    .ticket-details {
      margin-bottom: 5mm;
      border-bottom: 1px dashed #000;
      padding-bottom: 3mm;
    }
    .ticket-details p {
      margin-bottom: 2mm;
    }
    /* Tabla de productos */
    .ticket-items {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 5mm;
    }
    .ticket-items th, .ticket-items td {
      padding: 2mm;
      border-bottom: 1px dashed #000;
      text-align: left;
    }
    .ticket-items th {
      font-weight: bold;
      font-size: 12px;
    }
    /* Resumen de totales */
    .ticket-summary {
      margin-bottom: 5mm;
      border-top: 1px dashed #000;
      padding-top: 3mm;
    }
    .ticket-summary p {
      text-align: right;
      margin-bottom: 2mm;
    }
    /* Pie de ticket */
    .ticket-footer {
      text-align: center;
      font-size: 10px;
      line-height: 1.2;
    }
  </style>
</head>
<body>
  <div class="ticket-container">
    <!-- Encabezado -->
    <div class="ticket-header">
      <h1>{{ $document->company->name }}</h1>
      <p>{{ $document->company->address }}</p>
      <p>CP: {{ $document->company->zip_code }}</p>
    </div>

    <!-- Detalles de la venta -->
    <div class="ticket-details">
      <p><strong>Fecha:</strong> {{ $document->created_at->format('d/m/Y H:i') }}</p>
      <p><strong>Ticket No.:</strong> {{ str_pad($document->folio, 5, '0', STR_PAD_LEFT) }}</p>
      <p><strong>Vendedor:</strong> {{ $document->user->name }}</p>
    </div>

    <!-- Lista de productos -->
    <table class="ticket-items">
      <thead>
        <tr>
            <th>Cant.</th>
            <th>Producto</th>
            <th>Importe</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($document->items as $item)
            <tr>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->name }}</td>
                <td style="text-align:right;">$ {{ number_format($item->price, 2) }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Resumen de totales -->
    <div class="ticket-summary">
      <p>Subtotal: $ {{ number_format($document->subtotal, 2) }}</p>
      <p>IVA (16%): $ {{ number_format($document->tax, 2) }}</p>
      <p><strong>Total: $ {{ number_format($document->total, 2) }}</strong></p>
    </div>

    <!-- Pie del ticket -->
    <div class="ticket-footer">
      <p>¡Gracias por su compra!</p>
      <p>Visítenos nuevamente</p>
    </div>
  </div>
</body>
</html>
