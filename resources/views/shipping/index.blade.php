<x-app-layout>

    <x-container class="mt-12">

        <div class="grid grid-cols-3 gap-6">
 
            <div class="col-span-2">
                
            </div>

            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow overflow-hidden mb-4">

                    <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
                        <p class="font-semibold">
                            Resumen de compra ({{ Cart::instance('shopping')->count() }})
                        </p>

                        <a href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="p-4 text-gray-600">
                        <ul>
                            @foreach (Cart::content() as $item)
                                <li class="flex items-center space-x-4">
                                    <figure class="shrink-0">
                                        <img class="h-12 aspect-square" src="{{ $item->options->image }}" alt="">
                                    </figure>

                                    <div class="flex-1">
                                        <p>
                                            {{ $item->name }}
                                        </p>

                                        <p>
                                            ${{ $item->price }}
                                        </p>
                                    </div>

                                    <div class="shrink-0">
                                        <p>
                                            {{ $item->qty }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <hr class="my-4">

                        <div class="flex justify-between">
                            <p class="text-lg">
                                Total
                            </p>

                            <p>
                                ${{ Cart::subtotal() }}
                            </p>
                        </div>

                    </div>

                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-blue block w-full text-center">
                    Siguiente
                </a>

            </div>

        </div>

    </x-container>

</x-app-layout>