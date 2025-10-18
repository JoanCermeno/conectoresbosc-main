<div x-data="{ open: false }">
    <header 
        x-data="{ lastScroll: 0, visible: true }"
        :class="visible ? 'fixed top-0 left-0 w-full z-50 bg-black transition-all duration-300' : '-translate-y-full fixed top-0 left-0 w-full z-50 bg-black transition-all duration-300'"
        x-init="
            lastScroll = window.pageYOffset;
            window.addEventListener('scroll', () => {
                let current = window.pageYOffset;
                visible = current < 10 || current < lastScroll;
                lastScroll = current;
            });
        "
    >
       <x-container class="px-4 py-4">
            <div class="flex justify-between items-center space-x-8">
                <button class="text-2xl md:text-3xl" x-on:click="open = true">
                    <i class="fas fa-bars text-white"></i>
                </button>

                <h1 class="text-white">
                    <a href="/" class="inline-flex flex-col items-end">
                        <img src="{{ asset('img/icono.jpg') }}" alt="Logo" class="h-20 w-auto mx-auto">
                    </a>
                </h1>

                <div class="flex-1 hidden md:block">
                    @livewire('search-products')
                </div>

                <div class="flex items-center space-x-4 md:space-x-8">
                    <x-dropdown>
                        <x-slot name="trigger">
                            @auth
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                {{-- <button class="text-2xl md:text-3xl">
                                    <i class="fas fa-user text-white"></i>
                                </button> --}}
                            @endauth
                        </x-slot>
                        <x-slot name="content">
                            @guest
                                <div class="px-4 py-2">
                                    <div class="flex justify-center">
                                        <a href="{{ route('login')}}" class="btn btn-purple">
                                            Iniciar Sesión
                                        </a>
                                    </div>
                                    <p class="text-sm text-center mt-2">
                                        No tienes una cuenta?
                                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                                            Regístrate
                                        </a>
                                    </p>
                                </div>
                            @else
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Mi Perfil
                                </x-dropdown-link>
                                <div class="border-t border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            @endguest 
                        </x-slot>
                    </x-dropdown>
                    <a href="https://wa.me/+584246525131" target="_blank" class="flex items-center mr-4 hover:text-green-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.52 3.48A12.07 12.07 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.16 1.6 5.98L0 24l6.27-1.64A12.06 12.06 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.21-1.25-6.23-3.48-8.52zM12 22c-1.85 0-3.68-.5-5.26-1.44l-.38-.22-3.72.97.99-3.62-.25-.37A9.93 9.93 0 0 1 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.6c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.56-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.19.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.62-.47-.16-.01-.36-.01-.56-.01-.19 0-.5.07-.76.34-.26.27-1 1-.97 2.43.03 1.43 1.03 2.81 1.18 3 .15.19 2.03 3.1 4.93 4.23.69.27 1.23.43 1.65.55.69.22 1.32.19 1.81.12.55-.08 1.65-.67 1.88-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.19-.53-.33z"/>
                        </svg>
                    </a>

                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fas fa-shopping-cart text-white text-2xl md:text-3xl"></i>
                        <span id="cart-count" class="absolute -top-2 -end-4 inline-flex items-center justify-center w-6 h-6 bg-red-500 rounded-full text-xs font-bold text-white">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>
                </div>
            </div>
        </x-container>  

        <div class="-mt-6 md:hidden">
            @livewire('search-products')
        </div>

   </header>

   <div class="h-20"></div>

   <div x-show="open" x-on:click="open = false" style="display: none" class="fixed top-0 left-0 inset-0 bg-black bg-opacity-25 z-10"></div>

   <div x-show="open" style="display: none" class="fixed top-0 left-0 z-50">
    

        <div class="flex">

            <div class="w-screen sm:w-80 h-screen bg-white">

                <div class="bg-black px-4 py-3 text-white font-semibold">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">
                            Hola
                        </span>

                        <button x-on:click="open = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="h-[calc(100vh-52px)] overflow-auto">
                    <ul>
                        @foreach ($families as $family)
                            
                            <li wire:mouseover="$set('family_id', {{ $family->id }})">
                                <a href="{{ route('families.show', ['family' => $family->id]) }}"
                                   class="flex items-center justify-between px-4 py-4 text-gray-700 hover:bg-blue-200">
                                    {{ $family->name }}

                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>

                        @endforeach
                    </ul>
                </div>

            </div>

             <div class="w-80 xl:w-[57rem] pt-[52px] hidden md:block">

                <div class="bg-white h-[calc(100vh-52px)] overflow-auto px-6 py-8">

                    <div class="mb-8 flex justify-between items-center">
                        <p class="border-b-[3px] border-blue-800 uppercase text-xl font-semibold pb-1">
                            {{ $this->familyName }}
                        </p>

                        @if ($family_id)
                               <a href="{{ route('families.show', ['family' => $family->id]) }}" class="btn btn-blue">
                            Ver Todo
                        </a>@endif              
                   
                    </div>

                    <ul class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                        @foreach ($this->categories as $category)

                            <li>

                              <a href="{{ route('categories.show', $category) }}" class="text-black font-semibold text-lg">
                                  {{ $category->name }}
                              </a>

                              <ul class="mt-4 space-y-2">

                                    @foreach ($category->subcategories as $subcategory)

                                    <li>
                                        <a href="{{ route('subcategories.show', $subcategory) }}" class="text-sm text-gray-700 hover:text-blue-600">
                                            {{ $subcategory->name }}
                                        </a>
                                    </li>
                                        
                                    @endforeach

                              </ul>

                            </li>
                            
                        @endforeach
                    </ul>

                </div>
                
            </div>

        </div>
   </div>

   @push('js')

   <script>

    Livewire.on('cartUpdated', (count) => {
        document.getElementById('cart-count').innerText = count;
    });

         function search(value) {
            Livewire.dispatch('search', {
                search: value
            });
         }
   </script>
       
   @endpush

</div>

