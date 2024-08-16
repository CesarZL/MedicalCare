<x-app-layout>
    <div class="py-12">
        <div class="max-w-full px-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold leading-tight">Categorias</h2>
                        <div class="flex justify-end space-x-3">
                            <x-link-button  :href="route('categorias.create')">
                                Nueva categoria
                            </x-link-button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de creación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de actualización</th>
                                    <th class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100 divide-y divide-gray-200">
                                @foreach ($categorias as $categoria)    
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $categoria->nombre }}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $categoria->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $categoria->updated_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a class="text-blue-600 hover:text-blue-900" href="{{ route('categorias.show', $categoria) }}">
                                            Ver
                                        </a>
                                        <a class="text-yellow-600 hover:text-yellow-900 ml-4" href="{{ route('categorias.edit', $categoria) }}">
                                            Editar
                                        </a>
                                        <a href="{{ route('categorias.destroy', $categoria) }}" class="text-red-600 hover:text-red-900 ml-4" data-confirm-delete="true">
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