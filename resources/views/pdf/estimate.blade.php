<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Estimate</title>
  <style type="text/css">
    /* ========== RESETEO BÁSICO ========== */
    body, h1, h2, h3, p, table, th, td {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      color: #333333;
      background: #ffffff;
    }

    /* Contenedor principal */
    .container {
      /* width: 700px; */
      margin: 20px auto;
      padding: 20px;
      /* border: 1px solid #cccccc; */
    }

    /* Tablas generales */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    td {
      padding: 8px;
      vertical-align: top;
    }

    /* Encabezado */
    .header-table {
      margin-bottom: 20px;
    }

    .header-table td {
      vertical-align: middle;
    }

    .header-table h1 {
      font-size: 32px;
      font-weight: bold;
      color: #333333;
    }

    .logo {
      width: 100px;
      text-align: right;
    }

    .logo img {
      width: 100px;
    }

    /* Dirección y datos */
    .address-table td {
      width: 50%;
    }

    .address-table h3 {
      margin-bottom: 5px;
      font-size: 16px;
      font-weight: bold;
    }

    /* Información de la cotización */
    .estimate-info-table td {
      width: 25%;
    }

    .estimate-info-table p {
      line-height: 140%;
    }

    /* Tabla de items */
    .items-table th {
      background: #f9f9f9;
      text-align: left;
      padding: 8px;
      border: 1px solid #cccccc;
      font-weight: bold;
    }

    .items-table td {
      border: 1px solid #cccccc;
    }

    /* Totales */
    .totals-table {
      width: 50%;
      margin-left: 50%;
    }

    .totals-table td {
      text-align: right;
    }

    .totals-table td:last-child {
      width: 100px;
    }

    /* Firma */
    .signature {
      margin: 40px 0;
    }

    .signature p {
      font-style: italic;
    }

    /* Pie de página */
    .footer p {
      line-height: 150%;
    }

    /* Mensaje de agradecimiento */
    .thank-you {
      font-size: 18px;
      text-align: center;
      font-weight: bold;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- ENCABEZADO PRINCIPAL -->
    <table class="header-table">
      <tr>
        <td><h1>COTIZACIÓN</h1></td>
        <td class="logo">
          <img src="{{ $estimate->company->getFirstMediaPath('company') }}" alt="Logo">
        </td>
      </tr>
    </table>

    <!-- INFORMACIÓN DE DIRECCIONES -->
    <table class="address-table">
      <tr>
        <td colspan="2">
          <p><strong>{{ $estimate->company->name }}</strong></p>
          <p>{{ $estimate->company->address }}</p>
          <p>{{ $estimate->company->zip_code }}</p>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Cliente</h3>
          <p>{{ $estimate->entity->name }}</p>
          <p>{{ $estimate->address?->address_line_1 }}</p>
          <p>{{ $estimate->address?->address_line_2 }}</p>
        </td>
        <td>
          <h3>Datos fiscales</h3>
          <p>{{ $estimate->entity->rfc }}</p>
          <p>{{ $estimate->entity->regimenFiscal?->descripcion }}</p>
          <p>{{ $estimate->entity->usoCfdi?->descripcion }}</p>
        </td>
      </tr>
    </table>

    <!-- INFORMACIÓN DE LA COTIZACIÓN -->
    <table class="estimate-info-table">
      <tr>
        <td>
          <p><strong>Cotización #</strong></p>
          <p>{{ $estimate->folio }}</p>
        </td>
        <td>
          <p><strong>Fecha de cotización</strong></p>
          <p>{{ $estimate->date->format('d/m/Y') }}</p>
        </td>
        <td>
          <p><strong>Fecha de vencimiento</strong></p>
          <p>{{ $estimate->date->addDays(30)->format('d/m/Y') }}</p>
        </td>
        <td>
          <p><strong>Vendedor</strong></p>
          <p>{{ $estimate->user->name }}</p>
        </td>
      </tr>
    </table>

    <!-- TABLA DE ITEMS -->
    <table class="items-table">
      <thead>
        <tr>
          <th>Cant.</th>
          <th>Descripción</th>
          <th>Precio unitario</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($estimate->items as $item)
          <tr>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->total }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- RESUMEN DE TOTALES -->
    <table class="totals-table">
      <tr>
        <td>Subtotal:</td>
        <td>{{ number_format($estimate->subtotal, 2, '.', ',') }}</td>
      </tr>
      <tr>
        <td>IVA 16%:</td>
        <td>{{ number_format($estimate->tax, 2, '.', ',') }}</td>
      </tr>
      <tr>
        <td><strong>Total:</strong></td>
        <td><strong>{{ number_format($estimate->total, 2, '.', ',') }}</strong></td>
      </tr>
    </table>

    <!-- FIRMA -->
    <table class="signature">
      <tr>
        <td>
          <p>__________________________</p>
          <p>{{ $estimate->company->name }}</p>
        </td>
      </tr>
    </table>

    <!-- PIE DE PÁGINA -->
    <table class="footer">
      <tr>
        <td>
          <p>Payment is due within 15 days</p>
          <p>Name of Bank</p>
          <p>Account number: 123456789</p>
          <p>Routing # 987654321</p>
        </td>
      </tr>
    </table>

    <!-- MENSAJE DE AGRADECIMIENTO -->
    <div class="thank-you">
      Gracias
    </div>

  </div>
</body>
</html>