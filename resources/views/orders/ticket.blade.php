<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de Compra - Orden #{{ $order->id }}</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #3182ce;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-grid p {
            margin: 0;
            color: #4a5568;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        table th {
            background-color: #edf2f7;
            color: #2d3748;
            font-weight: bold;
        }
        
        table .total-row td {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            border-top: 2px solid #a0aec0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #718096;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu compra!</h1>
        </div>

        <div class="card">
            @php
                $customerName = isset($order->address['name']) ? $order->address['name'] : 'Cliente';
            @endphp
            <p style="text-align: center; font-size: 18px; margin-bottom: 20px;">
                Hola, <strong>{{ $customerName }}</strong>. Hemos recibido tu pedido y lo estamos procesando.
            </p>

            <p style="text-align: center; font-size: 16px; font-weight: bold; color: #4a5568;">
                Número de Orden: {{ $order->id }}
            </p>

            <div class="section-title">
                Resumen de la Orden
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->content as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Total:</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>
            <div class="section-title">
                Datos del Cliente
            </div>
            
            @if ($order->address)
                <div class="info-grid">
                    <p><strong>Nombre Completo:</strong> {{ $order->address['name'] ?? 'No especificado' }}</p>
                    <p><strong>Teléfono:</strong> {{ $order->address['phone_number'] ?? 'No especificado' }}</p>
                    <p><strong>Correo Electrónico:</strong> {{ $order->address['email'] ?? 'No especificado' }}</p>
                    <p><strong>Tipo de Entrega:</strong> {{ $order->address['delivery_type'] ?? 'No especificado' }}</p>
                </div>
                @if (isset($order->address['order_notes']) && $order->address['order_notes'] != '')
                    <p><strong>Notas del pedido:</strong> {{ $order->address['order_notes'] }}</p>
                @endif
            @else
                <p>Datos de cliente no disponibles.</p>
            @endif

            <div class="footer">
                <p>Gracias por tu compra.</p>
                <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
            </div>
        </div>
    </div>
    
</body>
</html>