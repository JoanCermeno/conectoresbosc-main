<div class="relative w-full">
    <input 
        wire:model.live="search" 
        wire:focus="setFocus"
        type="text" 
        placeholder="Buscar productos..." 
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm">

    @if ($showResults && strlen($search) >= 2)
        <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden max-h-60 overflow-y-auto">
            @if ($products->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <li class="p-2 hover:bg-gray-100 transition duration-150">
                            <a href="{{ route('products.show', $product) }}" class="flex items-center space-x-4">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                                <span class="text-sm font-medium text-gray-800">{{ $product->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-4 text-center text-gray-500">
                    No se encontraron productos que coincidan con la búsqueda.
                </div>
            @endif
        </div>
    @endif
</div>