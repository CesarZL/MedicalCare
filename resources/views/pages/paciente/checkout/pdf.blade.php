<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
       
        .info-container {
            display: flex;
            justify-content: space-between;
        }
        .info-container div {
            width: 48%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table td {
            text-align: right;
        }
        .table tfoot th {
            text-align: right;
        }
        .footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .section {
        display: flex;
        flex-direction: column;
        gap: 20px; /* Espacio entre las secciones */
        margin-bottom: 20px;
    }

    .info {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .title {
        font-weight: bold;
        color: #333;
    }

    .value {
        color: #666;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura</h1>
        
        <!-- Información de la venta -->
        <div class="section">
            <div class="info">
                <p class="title">Datos del paciente:</p>
                <p>Paciente: <span class="value">{{ $venta->paciente->user->name }}</span></p>
                <p>Teléfono: <span class="value">{{ $venta->paciente->user->telefono }}</span></p>
                <p>Email: <span class="value">{{ $venta->paciente->user->email }}</span></p>
            </div>
            <div class="info">
                <p class="title">Detalles de venta:</p>
                <p>Venta número: <span class="value">{{ $venta->id }}</span></p>
                <p>Fecha de venta: <span class="value">{{ $venta->fecha_de_venta }}</span></p>
            </div>
        </div>
        
        <!-- Items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->productos as $producto)
                    <tr>
                        <td>
                            <div>{{ $producto->nombre }}</div>
                            <div>{{ $producto->descripcion }}</div>
                        </td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ $producto->precio_venta }}</td>
                        <td>${{ number_format($producto->pivot->cantidad * $producto->precio_venta, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Subtotal (antes de IVA)</th>
                    <td>${{ $venta->subtotal }}</td>
                </tr>
                <tr>
                    <th colspan="3">IVA (16%)</th>
                    <td>${{ $venta->IVA }}</td>
                </tr>
                <tr>
                    <th colspan="3">Total (con IVA)</th>
                    <td>${{ $venta->total }}</td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Footer -->
        <div class="footer">
            <p>Gracias por tu compra</p>
        </div>
    </div>
</body>
</html>
