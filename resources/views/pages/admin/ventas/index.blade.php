<x-app-layout>
    <div class="py-12">
        <div class="max-w-full px-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto flex justify-between items-center mb-4 sm:pb-3 md:pb-3 pb-3">
                        <h2 class="text-2xl font-semibold leading-tight sm:mr-5 md:mr-5 lg:mr-5 xl:mr-5 mr-10">Ventas</h2>
                       <div class="flex justify-end space-x-3">
                            <x-link-button  :href="route('ventas.create')">
                                Nueva venta
                            </x-link-button>
                       </div>
                    </div>
                    <div class=" overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paciente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de venta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IVA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100 divide-y divide-gray-200">
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $venta->paciente->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $venta->fecha_de_venta }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $venta->subtotal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $venta->IVA }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $venta->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('ventas.detail', $venta->id) }}" class="text-green-600 hover:text-green-900 ml-4">Ver</a>
                                            <a href="{{ route('ventas.pdf', $venta->id) }}" class="text-blue-600 hover:text-blue-900 ml-4">PDF</a>
                                            <a href="{{ route('ventas.destroy', $venta) }}" class="text-red-600 hover:text-red-900 ml-4" data-confirm-delete="true">
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