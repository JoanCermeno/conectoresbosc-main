<div class="bg-white py-12 ">
    <x-container class="px-4 md:flex">

        @if (count($options)) 

              <aside class="md:w-52 md:flex-shrink-0 md:mr-8 mb-8 md:mb-0">

                <ul class="space-y-4">
                    @foreach ($options as $option)
                    <li x-data="{
                            open: true
                    }"> 
                            <button class="px-4 py-2 bg-gray-400 w-full text-left text-white flex justify-between items-center" x-on:click="open = !open">
                                {{ $option['name'] }}

                                <i class="fa-solid fa-angle-down"
                                x-bind:class="{
                                    'fa-angle-down': open,
                                    'fa-angle-up': !open,
                                }"></i>
                            </button>
                            <ul class="mt-2 space-y-2" x-show="open" >
                                @foreach ($option['features'] as $feature)
                                    <li>
                                        <label class="inline-flex items-center">

                                            <x-checkbox 
                                            value="{{ $feature['id'] }}"
                                            wire:model.live="selected_features"
                                            class="mr-2" />

                                            {{ $feature['description'] }}
                                        </label>
                                    
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </aside>

        @endif

          
        <div class="md:flex-1">

            <div class="flex items-center">
                <span class="mr-2">
                    Ordenar Por:
                </span>

                <x-select wire:model.live="orderBy">
                    <option value="1">
                        Relevancia
                    </option>

                    <option value="2">
                        Precio: Mayor a Menor
                    </option>

                     <option value="3">
                        Precio: Menor a Mayor 
                    </option>
                </x-select>
            </div>

            <hr class="my-4">


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($products as $product)
                 <div class="bg-white rounded-lg shadow-md overflow-hidden mx-4 sm:mx-0 flex flex-col">
            <a href="{{ route('products.show', $product) }}" class="block">
                <div class="w-full aspect-square bg-gray-100 flex items-center justify-center">
                    <img src="{{ $product->image }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover object-center transition-transform duration-200 hover:scale-105" />
                </div>
            </a>
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-lg mb-2">
                        <a href="{{ route('products.show', $product) }}" class="hover:underline">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="text-gray-700 mb-4">${{ $product->price }}</p>
                </div>
                <a href="{{ route('products.show', $product) }}"
                   class="inline-block bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-center transition">
                    Ver producto
                </a>
            </div>
        </div>
            @endforeach

            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>

          
        </div>

    </x-container>
</div>
