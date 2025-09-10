<x-app-layout>
    <div class="px-4 py-8 md:px-6 lg:px-8 mx-auto max-w-7xl">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 lg:p-10 text-center">
            
            <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">
                ¡Gracias por tu Orden!
            </h1>
            <p class="mt-2 text-base text-gray-600">
                Tu pedido #{{ $order->id }} ha sido recibido y está siendo procesado. En instantes un agente se pondrá en contacto contigo.
            </p>

            <hr class="my-6 border-gray-200">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 text-left">
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">
                        Resumen de la Orden
                    </h2>
                    <ul class="space-y-4">
                        @foreach($order->content as $item)
                        <li class="flex items-center space-x-4">
                            <img class="h-16 w-16 object-cover rounded-md" src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $item['qty'] }} x ${{ $item['price'] }}</p>
                            </div>
                            <p class="font-semibold text-gray-900">${{ $item['subtotal'] }}</p>
                        </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold mt-4 pt-4 border-t border-gray-200">
                        <span>Total:</span>
                        <span>${{ $order->total }}</span>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">
                        Información del Cliente
                    </h2>
                    @if ($order->address)
                        <div class="space-y-2 text-gray-600">
                            <p><b>Nombre:</b> {{ $order->address['name'] }}</p>
                            <p><b>Teléfono:</b> {{ $order->address['phone_number'] }}</p>
                            <p><b>Correo:</b> {{ $order->address['email'] }}</p>
                            <p><b>Tipo de Entrega:</b> {{ $order->address['delivery_type'] }}</p>
                        </div>
                    @else
                        <p class="text-gray-600">
                            Los datos del cliente no están disponibles.
                        </p>
                    @endif
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <p class="text-gray-600">
                Se ha enviado un correo de confirmación con los detalles de tu orden.
            </p>
           <a href="{{ route('order.download-ticket', ['order' => $order->id, 'timestamp' => $timestamp]) }}" class="inline-block mt-4 bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-800 transition duration-300">
                Descargar Ticket de Orden
            </a>
               
           
        </div>
    </div>
</x-app-layout>