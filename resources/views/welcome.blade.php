<x-app-layout>

    @push('css')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
        
    @endpush

    <div class="swiper mb-12">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->

            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img src="{{ $cover->image }}" class="w-full aspect-[3/1] object-center" alt="">
                </div>
            @endforeach
            

           
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>

    <x-container>

        <h1 class="text-2xl font-bold text-white mb-4">
            Lista de Productos
        </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
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
                    <p class="text-gray-700 mb-4">${{ number_format($product->price, 2) }}</p>
                </div>
                <a href="{{ route('products.show', $product) }}"
                   class="inline-block bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-center transition">
                    Ver producto
                </a>
            </div>
        </div>
    @endforeach
</div>

    </x-container>


    @push('js')
        
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
        // Optional parameters
        
        loop: true,

        autoplay: {
            delay: 8000,
        },

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    </script>


    @endpush

</x-app-layout>