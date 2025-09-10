<div>

    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

        <div class="lg:col-span-5">
            <div class="flex justify-between items-center mb-4 lg:mb-2">
                <h1 class="text-xl font-semibold text-white">
                    Carrito de Compras ({{ Cart::count() }} productos)
                </h1>

                <button class="font-semibold text-white hover:text-gray-600 underline hover:no-underline"
                wire:click="destroy()">
                    Limpiar carrito
                </button>
            </div>

            <div class="card p-4 sm:p-6 lg:p-8">
                <ul class="space-y-6">

                    @forelse (Cart::content() as $item)
                        <li class="flex items-start sm:items-center space-x-4 {{ $item->qty > $item->options['stock'] ? 'text-red-600' : ''}}">
                            <img class="w-20 h-20 object-cover object-center transition-transform duration-200 hover:scale-105" src="{{ $item->options->image }}" alt="">
                            <div class="flex-grow">
                                @if ($item->qty > $item->options['stock'])
                                    <p class="font-semibold text-sm">
                                        Stock Insuficiente
                                    </p>
                                @endif

                                <p class="text-sm font-medium truncate">
                                    <a href="{{ route('products.show', $item->id) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $item->name }}
                                    </a>
                                </p>
                                <p class="text-xs text-black">
                                    ${{ number_format($item->price, 2) }}
                                </p>
                                
                            </div>

                            <div class="flex items-center space-x-3 ml-auto">
                                <button class="btn btn-gray"
                                    wire:click="decrease('{{ $item->rowId }}')">
                                    -
                                </button>
                                <span class="w-6 text-center text-gray-700">
                                    {{ $item->qty }}
                                </span>
                                <button class="btn btn-gray"
                                    wire:click="increase('{{ $item->rowId }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="increase('{{ $item->rowId }}')"
                                    @disabled($item->qty >= $item->options['stock'])>
                                    +
                                </button>
                            </div>
                            
                            <button class="ml-4 text-gray-400 hover:text-red-500"
                                wire:click="remove('{{ $item->rowId }}')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </li>
                    @empty
                        <p class="text-center text-gray-500">
                            No hay productos en el carrito.
                        </p>
                    @endforelse

                </ul>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="card p-4 sm:p-6 lg:p-8">
                <div class="flex justify-between font-semibold mb-4">
                    <p>
                        Total:
                    </p>
                    <p>
                        $ {{ number_format($this->subtotal, 2) }}
                    </p>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-blue block w-full text-center">
                    Continuar Compra
                </a>
            </div>
        </div>

    </div>

</div>