<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'), 
    ],
    [
        'name' => 'Subcategorias',
        'route' => route('admin.subcategories.index'),
        
    ],
    [
        'name' => 'Nuevo',
    ]
]">

 {{-- <div class="card">
    <form action="{{ route('admin.subcategories.store')}}" method="POST">
     @csrf

        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-2" >
                    Categoria
            </x-label>

            <x-select name="category_id">
               @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id) >
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-select>

        </div>
        <div class="mb-4">
            <x-label class="mb-2">
                    Nombre
            </x-label>
            <x-input class="w-full"
                    placeholder="Ingrese el nombre de la Categoria"
                    name="name"
                    value="{{ old('name') }}"/>
        </div>
             <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>
   </div> --}}

   @livewire('admin.subcategories.subcategory-create', )


</x-admin-layout>
