<x-mail::message>
# ¡Gracias por tu compra, {{ $order->address['name'] }}!

Hemos recibido tu pedido y lo estamos procesando. Aquí tienes un resumen de tu compra.

## Resumen del Pedido

<x-mail::table>
| Producto | Cantidad | Precio Unitario | Subtotal |
| :--- | :---: | :---: | :---: |
@foreach($order->content as $item)
| {{ $item['name'] }} | {{ $item['qty'] }} | ${{ number_format($item['price'], 2) }} | ${{ number_format($item['price'] * $item['qty'], 2) }} |
@endforeach
| | | **Total:** | **${{ number_format($order->total, 2) }}** |
</x-mail::table>

Gracias por tu compra.

</x-mail::message>