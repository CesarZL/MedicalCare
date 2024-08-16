{{-- $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade'); // Nombre explícito de la tabla
$table->foreignId('producto_id')->constrained()->onDelete('cascade');
$table->integer('cantidad');
$table->decimal('precio', 8, 2);
$table->date('fecha_compra');
$table->decimal('descuento', 8, 2)->nullable();
$table->timestamps(); --}}

<x-app-layout>
    <div class="py-12">
        <div class="max-w-full px-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto flex justify-between items-center mb-4 sm:pb-3 md:pb-3 pb-3">
                        <h2 class="text-2xl font-semibold leading-tight sm:mr-5 md:mr-5 lg:mr-5 xl:mr-5 mr-10">Compras</h2>
                       <div class="flex justify-end space-x-3">
                            <x-link-button  :href="route('compras.create')">
                                Nueva compra
                            </x-link-button>

                       </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de compra</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio individual</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100 divide-y divide-gray-200">
                                
                                @foreach ($compras as $compra)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->producto->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->fecha_compra }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->cantidad }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ $compra->precio }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ $compra->total }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('compras.edit', $compra->id) }}" class="text-yellow-600 hover:text-yellow-900 ml-4">Editar</a>
                                        <a href="{{ route('compras.destroy', $compra) }}" class="text-red-600 hover:text-red-900 ml-4" data-confirm-delete="true">
                                            Borrar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
