<x-app-layout>
    <!-- component -->
    <div class="p-5 max-h-screen">
        <div class="flex lg:flex-row flex-col-reverse bg-white  sm:rounded-lg">
            <!-- left section -->
            <div class="w-full lg:w-3/5 sm:rounded-lg border">
                <!-- header -->
                <div class="flex flex-row justify-between items-center px-5 mt-5">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" class="block w-full p-4 ps-10 text-sm bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out" placeholder="Buscar productos..." />
                    </div>
                </div>

                <!-- products en grid con scroll -->
                <div class="px-5 my-5 max-h-[80vh] overflow-y-auto">
                    <div class="grid sm:grid-cols-4 grid-cols-2 gap-4" id="product-grid">
                        @foreach ($productos_inventario as $producto)
                        <div class="px-3 py-3 flex flex-col rounded-md h-32 justify-between bg-white border border-gray-300  hover:border hover:border-blue-500 transition duration-300 cursor-pointer producto"
                            data-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->nombre }}"
                            data-precio="{{ $producto->precio_venta }}"
                            data-cantidad="{{ $producto->cantidad }}">
                            <div>
                                <div class="font-bold text-blue-500 ">{{ $producto->nombre }}</div>
                                <div class="font-light text-sm text-gray-400">{{ $producto->categoria->nombre }}</div>
                                <div class="font-light text-sm text-gray-400">Disponibles: {{ $producto->cantidad }}</div>
                            </div>
                            <div class="flex flex-row justify-between items-center">
                                <div class="self-end font-bold text-lg text-blue-500">${{ $producto->precio_venta }}</div>
                            </div>
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="precio_venta" value="{{ $producto->precio_venta }}">
                            <input type="hidden" name="cantidad" value="{{ $producto->cantidad }}">
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- right section -->
            <div class="w-full lg:w-2/5">
                <form action="{{ route('ventas.store') }}" method="POST">
                    @csrf
                    <!-- header -->
                    <div class="flex flex-row items-center justify-between px-5 mt-5">
                        <div class="font-bold text-xl">Orden actual</div>
                        <div class="font-semibold">
                            <a type="button" href="{{ route('ventas.create') }}" class="px-4 py-2 rounded-md bg-red-100 text-red-500 hover:bg-red-500 hover:text-white cursor-pointer transition duration-300">
                                Cancelar
                            </a>
                        </div>
                    </div>

                    <!-- order list -->
                    <div class="mx-5 px-5 py-4 mt-5 overflow-y-auto h-56 border border-gray-300 rounded-md space-y-3" id="carrito">
                        {{-- Los productos del carrito se agregarán aquí dinámicamente --}}
                        @if(old('productos'))
                            @foreach(old('productos') as $id => $producto)
                                <div class="flex flex-row justify-between items-center" id="producto-{{ $id }}">
                                    <p class="font-semibold">{{ $producto['nombre'] }}</p>
                                    <div class="w-32 flex ml-auto sm:mr-16 mr-5 justify-between items-center">
                                        <span class="px-3 py-1 rounded-md bg-gray-100  text-gray-800  hover:bg-red-100 hover:text-red-500 cursor-pointer transition duration-300" onclick="decrementar({{ $id }}, {{ $producto['precio'] }})">-</span>
                                        <input type="number" class="form-input w-12 text-center appearance-none" value="{{ $producto['cantidad'] }}" style="text-align: center; -moz-appearance: textfield;" name="productos[{{ $id }}][cantidad]" id="cantidad-{{ $id }}" onchange="validarCantidad({{ $id }}, {{ $producto['cantidad'] }})">
                                        <span class="px-3 py-1 rounded-md bg-gray-100  text-gray-800  hover:bg-green-100 hover:text-green-500 cursor-pointer transition duration-300" onclick="incrementar({{ $id }}, {{ $producto['precio'] }}, {{ $producto['cantidad'] }})">+</span>
                                    </div>
                                    <div class="precio" id="precio-{{ $id }}">${{ $producto['precio'] }}</div>
                                    <input type="hidden" name="productos[{{ $id }}][id]" value="{{ $id }}">
                                    <input type="hidden" name="productos[{{ $id }}][precio]" value="{{ $producto['precio'] }}">
                                    <input type="hidden" name="productos[{{ $id }}][nombre]" value="{{ $producto['nombre'] }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- totalItems -->
                    <div class="px-5 mt-5">
                        <div class="py-4 rounded-md  border border-gray-300">
                            <div class=" px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Subtotal</span>
                                <span class="font-bold" id="subtotal">${{ old('subtotal', '0.00') }}</span>
                                <input type="hidden" name="subtotal" value="{{ old('subtotal', '0') }}">
                            </div>
                            <div class="px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Iva</span>
                                <span class="font-bold" id="iva">${{ old('iva', '0.00') }}</span>
                                <input type="hidden" name="iva" value="{{ old('iva', '0') }}">
                            </div>
                            <div class="px-4 flex items-center justify-between">
                                <span class="font-semibold text-lg">Total</span>
                                <span class="font-bold text-lg" id="total">${{ old('total', '0.00') }}</span>
                                <input type="hidden" name="total" value="{{ old('total', '0') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- client -->
                    <div class="px-5 mt-5">
                        <div class="rounded-md  px-4 py-6 border border-gray-300">
                            <x-label for="paciente_id" class="uppercase text-xs font-semibold" :value="__('Paciente')" />
                            <select class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" name="paciente_id" id="paciente_id">
                                <option value="" disabled selected>{{ __('Selecciona un paciente') }}</option>
                                @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>{{ $paciente->user->name }}</option>
                                @endforeach
                            </select>
                            <x-individual-input-error  :messages="$errors->get('paciente_id')" class="mt-2" />
                        </div>
                    </div>

                    <!-- button pay-->
                    <div class="px-5 mt-5 mb-5">
                        <x-button>
                            Crear venta
                        </x-button>
                    </div>                    
                </form>
                {{-- aquí termina el form --}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = document.querySelectorAll('.producto');
            const carrito = document.getElementById('carrito');
            const subtotalElement = document.getElementById('subtotal');
            const ivaElement = document.getElementById('iva');
            const totalElement = document.getElementById('total');
            const searchInput = document.getElementById('search');
            const productGrid = document.getElementById('product-grid');
            
            productos.forEach(producto => {
                producto.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    const precioConIva = parseFloat(this.dataset.precio);
                    const cantidadDisponible = parseInt(this.dataset.cantidad);
                    const ivaPorcentaje = 16; // IVA en México

                    let itemCarrito = document.getElementById(`producto-${id}`);
                    if (itemCarrito) {
                        // Si el producto ya está en el carrito, incrementa la cantidad
                        const cantidadInput = itemCarrito.querySelector(`#cantidad-${id}`);
                        let cantidadActual = parseInt(cantidadInput.value);

                        if (cantidadActual < cantidadDisponible) {
                            cantidadInput.value = cantidadActual + 1;
                            actualizarSubtotal();
                        } else {
                            alert('No hay suficiente stock disponible.');
                        }
                    } else {
                        // Si el producto no está en el carrito, agrégalo
                        if (cantidadDisponible > 0) {
                            itemCarrito = document.createElement('div');
                            itemCarrito.id = `producto-${id}`;
                            itemCarrito.classList.add('flex', 'flex-row', 'justify-between', 'items-center');
                            itemCarrito.innerHTML = `
                                <p class="font-semibold">${nombre}</p>
                                <div class="w-32 flex ml-auto sm:mr-16 mr-5 justify-between items-center">
                                    <span class="px-3 py-1 rounded-md bg-gray-100  text-gray-800  hover:bg-red-100 hover:text-red-500 cursor-pointer transition duration-300" onclick="decrementar(${id}, ${precioConIva})">-</span>
                                    <input type="number" class="form-input w-12 text-center appearance-none" value="1" style="text-align: center; -moz-appearance: textfield;" name="productos[${id}][cantidad]" id="cantidad-${id}" onchange="validarCantidad(${id}, ${cantidadDisponible})">
                                    <span class="px-3 py-1 rounded-md bg-gray-100  text-gray-800  hover:bg-green-100 hover:text-green-500 cursor-pointer transition duration-300" onclick="incrementar(${id}, ${precioConIva}, ${cantidadDisponible})">+</span>
                                </div>
                                <div class="precio" id="precio-${id}">$${precioConIva.toFixed(2)}</div>
                                <input type="hidden" name="productos[${id}][id]" value="${id}">
                                <input type="hidden" name="productos[${id}][precio]" value="${precioConIva}">
                                <input type="hidden" name="productos[${id}][nombre]" value="${nombre}">
                            `;
                            carrito.appendChild(itemCarrito);
                            actualizarSubtotal();
                        } else {
                            alert('No hay stock disponible.');
                        }
                    }
                });
            });

            window.incrementar = function(id, precioConIva, cantidadDisponible) {
                const itemCarrito = document.getElementById(`producto-${id}`);
                const cantidadInput = itemCarrito.querySelector(`#cantidad-${id}`);
                let cantidadActual = parseInt(cantidadInput.value);

                if (cantidadActual < cantidadDisponible) {
                    cantidadInput.value = cantidadActual + 1;
                    actualizarSubtotal();
                } else {
                    alert('No hay suficiente stock disponible.');
                }
            };

            window.decrementar = function(id, precioConIva) {
                const itemCarrito = document.getElementById(`producto-${id}`);
                const cantidadInput = itemCarrito.querySelector(`#cantidad-${id}`);
                let cantidadActual = parseInt(cantidadInput.value);

                if (cantidadActual > 1) {
                    cantidadInput.value = cantidadActual - 1;
                    actualizarSubtotal();
                } else {
                    carrito.removeChild(itemCarrito);
                    actualizarSubtotal();
                }
            };

            window.validarCantidad = function(id, cantidadDisponible) {
                const itemCarrito = document.getElementById(`producto-${id}`);
                const cantidadInput = itemCarrito.querySelector(`#cantidad-${id}`);
                let cantidadActual = parseInt(cantidadInput.value);

                if (cantidadActual > cantidadDisponible) {
                    alert('Cantidad ingresada excede el stock disponible.');
                    cantidadInput.value = cantidadDisponible;
                } else if (cantidadActual <= 0) {
                    carrito.removeChild(itemCarrito);
                }

                actualizarSubtotal();
            };

            function actualizarSubtotal() {
                let subtotal = 0;
                carrito.querySelectorAll('div[id^="producto-"]').forEach(item => {
                    const cantidad = parseInt(item.querySelector('input[type="number"]').value);
                    const precioConIva = parseFloat(item.querySelector('.precio').textContent.substring(1));
                    const iva = precioConIva * 0.16 / 1.16; // IVA incluido en el precio
                    const precioSinIva = precioConIva - iva;
                    subtotal += cantidad * precioSinIva;
                });

                let ivaTotal = subtotal * 0.16;
                let total = subtotal + ivaTotal;

                subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
                ivaElement.textContent = `$${ivaTotal.toFixed(2)}`;
                totalElement.textContent = `$${total.toFixed(2)}`;
            }

            searchInput.addEventListener('input', function() {
                let filter = searchInput.value.toLowerCase();
                productos.forEach(producto => {
                    let nombre = producto.dataset.nombre.toLowerCase();
                    if (nombre.includes(filter)) {
                        producto.style.display = 'block';
                    } else {
                        producto.style.display = 'none';
                    }
                });
            });

            
        });
    </script>
</x-app-layout>
