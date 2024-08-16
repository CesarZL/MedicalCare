<x-app-layout>
    <!-- component -->
    <div class="p-5 max-h-screen">
        <div class="flex lg:flex-row flex-col-reverse bg-white dark:bg-slate-800 sm:rounded-lg">
            <!-- left section -->
            <div class="w-full lg:w-3/5 sm:rounded-lg bg-gray-50 dark:bg-gray-700">
                <!-- header -->
                <div class="flex flex-row justify-between items-center px-5 mt-5">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Buscar productos..." />
                    </div>
                </div>

                <!-- products en grid con scroll -->
                <div class="px-5 my-5 max-h-[80vh] overflow-y-auto">
                    <div class="grid sm:grid-cols-4 grid-cols-2 gap-4" id="product-grid">
                        @foreach ($productos_inventario as $producto)
                        <div class="px-3 py-3 flex flex-col rounded-md h-32 justify-between bg-white border border-gray-300 dark:border-gray-500 dark:bg-slate-800 hover:border hover:border-indigo-500 transition duration-300 cursor-pointer producto"
                            data-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->nombre }}"
                            data-precio="{{ $producto->precio_venta }}"
                            data-cantidad="{{ $producto->cantidad }}">
                            <div>
                                <div class="font-bold text-indigo-500 dark:text-gray-100">{{ $producto->nombre }}</div>
                                <div class="font-light text-sm text-gray-400">{{ $producto->categoria->nombre }}</div>
                                <div class="font-light text-sm text-gray-400">Disponibles: {{ $producto->cantidad }}</div>
                            </div>
                            <div class="flex flex-row justify-between items-center">
                                <div class="self-end font-bold text-lg text-indigo-500">${{ $producto->precio_venta }}</div>
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
                    <div class="mx-5 px-5 py-4 mt-5 overflow-y-auto h-56 border border-slate-600 rounded-md space-y-3" id="carrito">
                        {{-- Los productos del carrito se agregarán aquí dinámicamente --}}
                        @foreach ($venta->productos as $producto)
                        <div id="producto-{{ $producto->id }}" class="flex flex-row justify-between items-center">
                            <p class="font-semibold">{{ $producto->nombre }}</p>
                            <div class="w-32 flex ml-auto sm:mr-16 mr-5 justify-between items-center">
                                <span class="px-3 py-1 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 hover:bg-red-100 hover:text-red-500 cursor-pointer transition duration-300" onclick="decrementar({{ $producto->id }}, {{ $producto->precio_venta }})">-</span>
                                <input type="number" class="form-input w-12 text-center appearance-none" value="{{ $producto->pivot->cantidad }}" style="text-align: center; -moz-appearance: textfield;" name="productos[{{ $producto->id }}][cantidad]" id="cantidad-{{ $producto->id }}" onchange="validarCantidad({{ $producto->id }}, {{ $producto->cantidad }})">
                                <span class="px-3 py-1 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 hover:bg-green-100 hover:text-green-500 cursor-pointer transition duration-300" onclick="incrementar({{ $producto->id }}, {{ $producto->precio_venta }}, {{ $producto->cantidad }})">+</span>
                            </div>
                            <div class="precio" id="precio-{{ $producto->id }}">${{ $producto->precio_venta }}</div>
                            <input type="hidden" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}">
                            <input type="hidden" name="productos[{{ $producto->id }}][precio]" value="{{ $producto->precio_venta }}">
                            <input type="hidden" name="productos[{{ $producto->id }}][nombre]" value="{{ $producto->nombre }}">
                        </div>
                        @endforeach
                    </div>

                    <!-- totalItems -->
                    <div class="px-5 mt-5">
                        <div class="py-4 rounded-md shadow-lg border border-slate-600">
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

                    <!-- cash -->
                    <div class="px-5 mt-5">
                        <div class="rounded-md shadow-lg px-4 py-6 border border-slate-600">
                            <x-label for="pago_id" class="uppercase text-xs font-semibold" :value="__('Forma de pago')" />
                            <select class="form-select w-full dark:bg-[#0f172a]/30" name="pago_id" id="pago_id">
                                <option value="" disabled selected>{{ __('Selecciona una forma de pago') }}</option>
                                @foreach ($formasdepago as $formadepago)
                                    <option value="{{ $formadepago->id }}" {{ old('pago_id', $venta->pago_id) == $formadepago->id ? 'selected' : '' }}>{{ $formadepago->tipo }}</option>
                                @endforeach
                            </select>
                            <x-individual-input-error  :messages="$errors->get('pago_id')" class="mt-2" />

                            <x-label for="monto" class="mt-4 uppercase text-xs font-semibold" :value="__('Monto')" />
                            <input type="number" class="form-input w-full dark:bg-[#0f172a]/30" name="monto" id="monto" placeholder="Ingrese el monto recibido" value="{{ old('monto') }}" {{ old('pago_id') != 3 ? 'disabled' : '' }} />
                            <x-individual-input-error  :messages="$errors->get('monto')" class="mt-2" />
                        </div>
                    </div>
                    
                    <!-- client -->
                    <div class="px-5 mt-5">
                        <div class="rounded-md shadow-lg px-4 py-6 border border-slate-600">
                            <x-label for="cliente_id" class="uppercase text-xs font-semibold" :value="__('Paciente')" />
                            <select class="form-select w-full dark:bg-[#0f172a]/30" name="cliente_id" id="cliente_id">
                                <option value="" disabled selected>{{ __('Selecciona un paciente') }}</option>
                                @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('cliente_id', $venta->cliente_id) == $paciente->id ? 'selected' : '' }}>{{ $paciente->nombre }}</option>
                                @endforeach
                            </select>
                            <x-individual-input-error  :messages="$errors->get('cliente_id')" class="mt-2" />
                        </div>
                    </div>

                    <!-- button pay-->
                    <div class="px-5 mt-5 mb-5">
                        <button type="submit" class="w-full px-4 py-4 rounded-md shadow-lg text-center bg-indigo-500 text-white font-semibold hover:bg-indigo-600 cursor-pointer transition duration-300">
                            Pagar
                        </button>
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
    const montoInput = document.getElementById('monto');
    const pagoSelect = document.getElementById('pago_id');
    const searchInput = document.getElementById('search');
    
    // Inicializar el carrito de compras
    productos.forEach(producto => {
        producto.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precioConIva = parseFloat(this.dataset.precio);
            const cantidadDisponible = parseInt(this.dataset.cantidad);
            
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
                            <span class="px-3 py-1 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 hover:bg-red-100 hover:text-red-500 cursor-pointer transition duration-300" onclick="decrementar(${id})">-</span>
                            <input type="number" class="form-input w-12 text-center appearance-none" value="1" style="text-align: center; -moz-appearance: textfield;" name="productos[${id}][cantidad]" id="cantidad-${id}" onchange="validarCantidad(${id}, ${cantidadDisponible})">
                            <span class="px-3 py-1 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 hover:bg-green-100 hover:text-green-500 cursor-pointer transition duration-300" onclick="incrementar(${id}, ${cantidadDisponible})">+</span>
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
    
    window.incrementar = function(id, cantidadDisponible) {
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

    window.decrementar = function(id) {
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
        if (itemCarrito) {
            const cantidadInput = itemCarrito.querySelector(`#cantidad-${id}`);
            let cantidadActual = parseInt(cantidadInput.value);

            if (cantidadActual > cantidadDisponible) {
                alert('Cantidad ingresada excede el stock disponible.');
                cantidadInput.value = cantidadDisponible;
            } else if (cantidadActual <= 0) {
                carrito.removeChild(itemCarrito);
            }

            actualizarSubtotal();
        }
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

        document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
        document.querySelector('input[name="iva"]').value = ivaTotal.toFixed(2);
        document.querySelector('input[name="total"]').value = total.toFixed(2);
    }

    pagoSelect.addEventListener('change', function() {
        if (parseInt(this.value) === 3) { // Efectivo
            montoInput.disabled = false;
        } else {
            montoInput.disabled = true;
            montoInput.value = ''; // Clear the input if the payment method is not cash
        }
    });

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

    // Llamar a actualizarSubtotal() al cargar la página para calcular los valores iniciales
    actualizarSubtotal();
});


    </script>
    
</x-app-layout>
