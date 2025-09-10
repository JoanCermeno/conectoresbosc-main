@php
    $links = [
        [   
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard') 
        ],
        [
            'header' => 'Administrar pagina',
        ],
        [
            'name' => 'Opciones',
            'icon' => 'fa-solid fa-cog',
            'route' => route('admin.options.index'),
            'active' => request()->routeIs('admin.options.*')
        ],
        [
            // Familia de productos
            'name' => 'Familias',
            'icon' => 'fa-solid fa-box-open',
            'route' => route('admin.families.index'),
            'active' => request()->routeIs('admin.families.*') 
        ],
         [
            // Familia de Categorias
            'name' => 'Categorías',
            'icon' => 'fa-solid fa-tags',
            'route' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*') 
        ],
            [
            // Familia de SubCategorias
            'name' => 'Subcategorías',
            'icon' => 'fa-solid fa-tag',
            'route' => route('admin.subcategories.index'),
            'active' => request()->routeIs('admin.subcategories.*') 
        ],
              [
            // Familia de Productos
            'name' => 'Productos',
            'icon' => 'fa-solid fa-box',
            'route' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*') 
        ],
        [
            'name' => 'Portadas',
            'icon' => 'fa-solid fa-images',
            'route' => route('admin.covers.index'),
            'active' => request()->routeIs('admin.covers.*'),
        ],
        [
            'header' => 'Ordenes y Envios'
        ],
        [
            'name' => 'Conductores',
            'icon' => 'fa-solid fa-truck',
            'route' => route('admin.drivers.index'),
            'active' => request()->routeIs('admin.drivers.*')
        ],
        [
            'name' => 'Ordenes',
            'icon' => 'fa-solid fa-shopping-cart',
            'route' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.*'),
        ],
        [
            'name' => 'Envios',
            'icon' => 'fa-solid fa-shipping-fast',
            'route' => route('admin.shipments.index'),
            'active' => request()->routeIs('admin.shipments.*')    
],

    ];
@endphp


<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
:class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">

        @foreach ($links as $link)
            
      
            <li>
                @isset($link['header'])
                    
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                        {{ $link['header'] }}
                    </div>

                    @else
          
                    <a href="{{ $link['route'] }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group 
                    {{ $link['active'] ? 'bg-gray-500' : '' }}">
                        
                        <span class="inline-flex w-6 h-6 justify-center items-center"> 
                            <i class="{{$link['icon']}} text-gray-1000"></i>
                        </span>  
                            
                        <span class="ms-2">{{$link['name']}}</span>
                    </a>
                @endisset
            </li>
        @endforeach
      </ul>
   </div>
</aside>