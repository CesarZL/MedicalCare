<x-app-layout>

  <section class="relative py-16">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mx-auto max-md:px-2 ">
            <div class="img ">
                <div class="img-box h-full max-lg:mx-auto ">
                    <img src="{{asset($producto->imagen)}}" alt="{{ $producto->nombre }}" class="max-lg:mx-auto rounded-2xl ml-auto h-full shadow-md">
                </div>
            </div>
            <div
                class="data w-full lg:pr-8 pr-0 xl:justify-start justify-center flex items-center max-lg:pb-10 xl:my-2 lg:my-5 my-0">
                <div class="data w-full max-w-xl">
                    <p class="text-lg font-medium leading-8 text-blue-600 mb-4">{{ $producto->marca }}</p>
                    <h2 class="font-manrope font-bold text-3xl leading-10 text-gray-900 mb-2 capitalize">{{ $producto->nombre }}</h2>
                    <div class="flex flex-col sm:flex-row sm:items-center mb-6">
                        <h6 class="font-manrope font-semibold text-2xl leading-9 text-gray-900 pr-5  border-gray-200 mr-5">${{ $producto->precio_venta }}</h6>
                    </div>
                    <p class="text-gray-500 text-base font-normal mb-5">
                        {{ $producto->descripcion }}
                    </p>

                    @auth
                        @if (Auth::user()->rol == 2)
                            <form action="{{ route('carrito.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 py-8">
                                    <div class="flex sm:items-center sm:justify-center w-full">
                                        <button type="button" id="decrease" class="group py-4 px-6 border border-gray-400 rounded-l-lg bg-white transition-all duration-300 hover:bg-gray-50 hover:shadow-sm hover:shadow-gray-300">
                                            <svg class="stroke-gray-900 group-hover:stroke-black" width="22" height="22"
                                                viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.5 11H5.5" stroke="" stroke-width="1.6" stroke-linecap="round" />
                                                <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                                                    stroke-linecap="round" />
                                                <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <input type="number" name="cantidad" id="cantidad" class="font-semibold text-gray-900 cursor-pointer text-lg py-[13px] px-6 w-full sm:max-w-[118px] outline-0 border-y border-gray-400 bg-transparent placeholder:text-gray-900 text-center hover:bg-gray-50 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" value="1" min="1">
                                        <button type="button" id="increase" class="group py-4 px-6 border border-gray-400 rounded-r-lg bg-white transition-all duration-300 hover:bg-gray-50 hover:shadow-sm hover:shadow-gray-300">
                                            <svg class="stroke-gray-900 group-hover:stroke-black" width="22" height="22"
                                                viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="#9CA3AF" stroke-width="1.6"
                                                    stroke-linecap="round" />
                                                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="black" stroke-opacity="0.2"
                                                    stroke-width="1.6" stroke-linecap="round" />
                                                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="black" stroke-opacity="0.2"
                                                    stroke-width="1.6" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                            
                                    {{-- input hidden del producto --}}
                                    <input type="text" class="hidden"  name="producto_id" value="{{ $producto->id }}">
                            
                                    <x-button class="group py-4 px-5 rounded-full bg-blue-100 text-blue-600 font-semibold text-lg w-full flex items-center justify-center gap-2 transition-all duration-500 hover:bg-blue-200">
                                        Añadir al carrito
                                    </x-button>
                                </div>
                            </form>
                        @else
                            <a class="group py-4 px-5 rounded-full bg-blue-100 text-blue-600 font-semibold text-lg w-full flex items-center justify-center gap-2 transition-all duration-500 hover:bg-blue-200">
                                Iniciar sesión como paciente para comprar
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="group py-4 px-5 rounded-full bg-blue-100 text-blue-600 font-semibold text-lg w-full flex items-center justify-center gap-2 transition-all duration-500 hover:bg-blue-200">
                            Iniciar sesión para comprar
                        </a>
                    @endauth

                    <x-validation-errors class="mt-2 text-center" :errors="$errors" />

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('increase').addEventListener('click', function() {
        let cantidad = document.getElementById('cantidad');
        cantidad.value = parseInt(cantidad.value) + 1;
    });

    document.getElementById('decrease').addEventListener('click', function() {
        let cantidad = document.getElementById('cantidad');
        if (cantidad.value > 1) {
            cantidad.value = parseInt(cantidad.value) - 1;
        }
    });

    document.getElementById('cantidad').addEventListener('input', function() {
        let cantidad = document.getElementById('cantidad');
        if (parseInt(cantidad.value) < 1 || isNaN(cantidad.value)) {
            cantidad.value = 1;
        }
    });
</script>


                                                                      
</x-app-layout>


                     