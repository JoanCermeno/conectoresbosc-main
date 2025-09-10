<x-app-layout>

     <x-container class="px-4 my-4">
        

        <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Home
            </a>
            </li>

            <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('families.show', $product->subcategory->category->family) }}"
                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-950 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                     {{ $product->subcategory->category->family->name }}
                </a>
                </div>
            </li>

            
            <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('categories.show', $product->subcategory->category) }}"
                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-950 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                    {{ $product->subcategory->category->name }}
                </a>
                </div>
            </li>

             <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('categories.show', $product->subcategory->category) }}"
                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-950 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                    {{ $product->subcategory->name }}
                </a>
                </div>
            </li>
           
        </ol>
        </nav>


    </x-container>

    <x-container>
        <div class="card">
            <div class="grid md:grid-cols-2 gap-6">
            
                <div class="col-span-1">
                    <figure>
                        <img src="{{ $product->image }}" class="w-full h-full object-cover object-center transition-transform duration-200 hover:scale-105" alt="">
                    </figure>      
                    
                    {{-- <div class="text-sm">
                        {{ $product->description }}
                    </div> --}}
                </div>

                <div class="col-span-1">
                    @livewire('products.add-to-cart', ['product' => $product])
                </div>
            </div>

        </div>

    </x-container>

    {{-- Sección de Otros Productos --}}
    <x-container class="my-6">
        <h2 class="text-2xl font-bold text-white mb-6">Otros productos que podrían interesarte</h2>
        
        @php
            $otherProducts = \App\Models\Product::where('id', '!=', $product->id)->inRandomOrder()->take(5)->get();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($otherProducts as $item)
                <a href="{{ route('products.show', $item) }}" class="card">
                    <figure>
                        <img src="{{ $item->image }}" class="h-48 w-full object-cover object-center transition-transform duration-200 hover:scale-105" alt="{{ $item->name }}">
                    </figure>
                    <div class="p-4 text-center">
                        <p class="text-lg font-semibold text-gray-800 line-clamp-2">{{ $item->name }}</p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-lg font-semibold text-gray-800">${{ number_format($item->price, 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </x-container>


</x-app-layout>