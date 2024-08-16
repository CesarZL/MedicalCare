<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 xl:flex">
                    <!-- Enlaces visibles para todos -->
                    <x-nav-link href="{{ route('welcome') }}" :active="request()->routeIs('welcome')">
                        Inicio
                    </x-nav-link>

                    <x-nav-link href="{{ route('productos') }}" :active="request()->routeIs('productos')">
                        Productos
                    </x-nav-link>

                    @guest
                        <!-- Enlaces visibles solo para no autenticados -->
                        <x-nav-link href="{{ route('medicos') }}" :active="request()->routeIs('medicos')">
                            Citas médicas
                        </x-nav-link>
                    @endguest

                    @auth
                        @if (Auth::user()->rol != 1)
                            <!-- Enlaces visibles para usuarios no con rol 1 -->
                            <x-nav-link href="{{ route('medicos') }}" :active="request()->routeIs('medicos')">
                                Citas médicas
                            </x-nav-link>
                        @endif
                    @endauth

                    <x-nav-link href="{{ route('contacto') }}" :active="request()->routeIs('contacto')">
                        Contacto
                    </x-nav-link>

                    @auth
                        @if (Auth::user()->rol == 0)
                            <!-- Enlaces para usuarios con rol 0 -->
                            <x-nav-link href="{{ route('productos.index') }}" :active="request()->routeIs('productos.index')">
                                Administrar Productos
                            </x-nav-link>

                            <x-nav-link href="{{ route('categorias.index') }}" :active="request()->routeIs('categorias.index')">
                                Categorias
                            </x-nav-link>

                            <x-nav-link href="{{ route('inventarios.index') }}" :active="request()->routeIs('inventarios.index')">
                                Inventarios
                            </x-nav-link>

                            <x-nav-link href="{{ route('compras.index') }}" :active="request()->routeIs('compras.index')">
                                Compras
                            </x-nav-link>

                            <x-nav-link href="{{ route('ventas.index') }}" :active="request()->routeIs('ventas.index')">
                                Ventas
                            </x-nav-link>

                            <x-nav-link href="{{ route('pacientes.index') }}" :active="request()->routeIs('pacientes.index')">
                                Pacientes
                            </x-nav-link>

                            <x-nav-link href="{{ route('medicos.index') }}" :active="request()->routeIs('medicos.index')">
                                Médicos
                            </x-nav-link>
                        @endif

                        @if (Auth::user()->rol == 1)
                            <!-- Enlaces para usuarios con rol 1 -->
                            <x-nav-link href="{{ route('citas.medico.mis-citas') }}" :active="request()->routeIs('citas.medico.mis-citas')">
                                Mis citas
                            </x-nav-link>
                        @endif

                        @if (Auth::user()->rol == 2)
                            <!-- Enlaces para usuarios con rol 2 -->
                            <x-nav-link href="{{ route('citas.paciente.mis-citas') }}" :active="request()->routeIs('citas.paciente.mis-citas')">
                                Mis citas
                            </x-nav-link>

                            <x-nav-link href="{{ route('compras.mis-compras') }}" :active="request()->routeIs('compras.mis-compras')">
                                Mis compras
                            </x-nav-link>

                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden xl:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400 text-center">
                                    Manejar cuenta
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Ver perfil
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link class="rounded-b-md bg-red-400 text-white hover:text-red-400" href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                        Cerrar sesión
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @elseguest 
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        Mi cuenta
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
                        
                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400 text-center">
                                    Conectarme a mi cuenta
                                </div>
                        
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Iniciar sesión
                                </x-dropdown-link>
                        
                                <div class="border-t border-gray-200"></div>
                        
                                <p class="block px-4 py-2 text-xs text-gray-400 text-center">
                                    ¿No tienes cuenta?
                                </p>
                        
                                <x-dropdown-link class="rounded-b-md" href="{{ route('register') }}">
                                    Regístrate
                                </x-dropdown-link>
                        
                            </x-slot>
                        </x-dropdown>
                    @endauth 
                </div>

                @auth
                    @if (Auth::user()->rol == 2)
                        <div class="ml-2 flow-root lg:ml-6">
                            <a href="#" class="group -m-2 flex items-center p-2" id="openCartMenu">
                                <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </a>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center xl:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
