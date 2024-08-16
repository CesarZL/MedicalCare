<x-app-layout>
    <div class="py-12">
        <div class="max-w-full px-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold leading-tight">Médicos</h2>
                        <div class="flex justify-end space-x-3">
                            <x-link-button  :href="route('medicos.create')">
                                Nuevo médico
                            </x-link-button>
                        </div>
                    </div>
                    <div class=" overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefono</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo electrónico</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CURP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100 divide-y divide-gray-200">
                                @foreach ($medicos as $medico)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset($medico->imagen) }}" alt="{{ $medico->user->name }}" class="w-20 h-20 object-cover rounded-lg">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->user->telefono }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->user->curp }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->cedula }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $medico->especialidad }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a class="text-yellow-600 hover:text-yellow-900 ml-4"  href="{{ route('medicos.edit', $medico) }}">Editar</a>
                                            <a href="{{ route('medicos.destroy', $medico) }}" class="text-red-600 hover:text-red-900 ml-4" data-confirm-delete="true">
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