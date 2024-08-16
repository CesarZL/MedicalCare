<!-- Menú del carrito -->
<div id="cartMenu" class="hidden fixed inset-0 z-10">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <!-- Contenido del menú aquí -->
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Carrito de compras</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" id="closeMenu" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Productos aquí -->

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">

                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fin del contenido -->
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Total</p>
                                <p id="cart-total">$0.00</p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('checkout.index') }}"
                                class="inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200 w-full">Ir a pagar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para abrir y cerrar el menú -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartMenu = document.getElementById('cartMenu');

        document.getElementById('openCartMenu').addEventListener('click', () => {
            axios.get('/carrito-productos')
                .then(response => {
                    const { productos, total } = response.data;
                    const productosList = cartMenu.querySelector('ul');
                    productosList.innerHTML = '';

                    productos.forEach(producto => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('flex', 'py-6');
                        listItem.innerHTML = `
                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                <img src="/${producto.imagen}" alt="${producto.nombre}" class="h-full w-full object-cover object-center">
                            </div>
                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>${producto.nombre}</h3>
                                        <p class="ml-4">$${producto.precio_venta*producto.pivot.cantidad}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">${producto.marca}</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                    <p class="text-gray-500">Cantidad: ${producto.pivot.cantidad}</p>
                                    <div class="flex">
                                        <button type="button" data-id="${producto.id}" class="remove-item font-medium text-blue-400 hover:text-blue-500">Quitar</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        productosList.appendChild(listItem);
                    });

                    // Actualizar el total
                    const totalElement = cartMenu.querySelector('#cart-total');
                    totalElement.innerHTML = `$${total.toFixed(2)}`;

                    cartMenu.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching carrito productos:', error);
                });
        });

        document.getElementById('closeMenu').addEventListener('click', () => {
            cartMenu.classList.add('hidden');
        });

        cartMenu.addEventListener('click', event => {
            if (event.target.classList.contains('remove-item')) {
                const productoId = event.target.getAttribute('data-id');

                axios.delete(`/carrito-productos/${productoId}`)
                    .then(response => {
                        console.log(response.data.message);
                        event.target.closest('li').remove();
                    })
                    .catch(error => {
                        console.error('Error removing producto:', error);
                    });
            }
        });
    });
</script>
