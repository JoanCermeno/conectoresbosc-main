<x-app-layout>

    <div class="px-4 py-8 md:px-6 lg:px-8 xl:px-12 2xl:px-16 mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_minmax(auto,_20rem)] gap-8 lg:gap-16">

            <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
                <div class="flex items-center mb-6">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="font-semibold">Volver</span>
                    </a>
                </div>

                <h2 class="text-3xl font-semibold text-gray-800 mb-6">Finalizar Orden</h2>

                <form action="{{ route('checkout.paid') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Detalles de facturación</h3>
                        
                        <div class="mb-4">
                            <label for="delivery_type" class="block text-gray-700 font-medium mb-2">Tipo de Entrega. <span class="text-red-500">*</span></label>
                            <select id="delivery_type" name="delivery_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="Retiro en tienda">Retiro en tienda</option>
                                <option value="Envío a domicilio">Envío a domicilio</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Nombre Cliente. <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-gray-700 font-medium mb-2">Número de Teléfono. <span class="text-red-500">*</span></label>
                            <input type="number" id="phone_number" name="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Correo electrónico. <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300">

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Información adicional</h3>
                        
                        <div class="mb-4">
                            <label for="order_notes" class="block text-gray-700 font-medium mb-2">Notas del pedido (opcional)</label>
                            <textarea id="order_notes" name="order_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Notas sobre tu pedido, por ejemplo, notas especiales para la entrega."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Finalizar Compra
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg h-fit">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Resumen del Pedido</h3>
                
                <ul class="space-y-4 mb-4">
                    @foreach ($content as $item)
                        <li class="flex items-center space-x-4">
                            <div class="flex-shrink-0 relative">
                                <img class="h-16 w-16 object-cover rounded-lg" src="{{ $item->options->image }}" alt="">
                                <div class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                    <span class="text-white font-semibold text-sm">{{ $item->qty }}</span>
                                </div>
                            </div>

                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $item->name }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($item->price, 2) }}</p>                                
                                <p class="font-semibold text-gray-800">${{ $item->subtotal }}</p>
                            </div>

                        </li>
                    @endforeach
                </ul>

                <div class="border-t border-gray-300 pt-4">
                    {{-- <div class="flex justify-between font-semibold mb-2">
                        <p class="text-gray-700">Subtotal:</p>
                        <p class="text-gray-800">${{ number_format($subtotal, 2) }}</p>
                    </div> --}}

                    <div class="flex justify-between mb-4">
                        <p class="text-lg font-bold text-gray-800">Total:</p>
                        <p class="text-lg font-bold text-gray-800">${{ Cart::instance('shopping')->subtotal() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>