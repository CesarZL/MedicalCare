<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis citas médicas
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($citas as $cita)
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <div class="flex flex-col items-center p-6">
                        <img class="w-28 h-28 mb-3 rounded-2xl shadow-lg" src="{{ asset($cita->medico->imagen) }}" alt="{{ $cita->medico->user->name }}">
                        <h5 class="capitalize text-xl font-medium text-gray-900 text-center">
                            {{ $cita->medico->user->name }}
                        </h5>
                        <span class="my-3 text-sm text-gray-500 capitalize text-center">
                            {{ $cita->medico->especialidad }}
                        </span>
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ring-blue-700/10">
                            {{ $cita->fecha_hora->format('d/m/Y H:i') }}
                        </span>

                        @php
                            $statusClasses = [
                                'pendiente' => 'text-yellow-700 bg-yellow-50 ring-yellow-700/10',
                                'cancelada' => 'text-red-700 bg-red-50 ring-red-700/10',
                                'aceptada' => 'text-green-700 bg-green-50 ring-green-700/10',
                                'completada' => 'text-blue-700 bg-blue-50 ring-blue-700/10',
                            ];
                        @endphp

                        <span class="mt-3 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses[$cita->status] }}">
                            {{ $cita->status }}
                        </span>

                        <div class="flex mt-4 md:mt-6">
                            @if ($cita->status == 'pendiente')
                                <form action="{{ route('cita.cancelar', $cita->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="rounded-lg text-sm font-semibold py-2 px-4 ms-2 bg-white border border-red-100 text-red-400 hover:text-red-400 hover:bg-red-100" data-confirm-delete="true">
                                        Cancelar cita
                                    </button>
                                </form>
                            @elseif ($cita->status == 'cancelada')
                                <div class="rounded-lg text-sm font-semibold py-2 px-4 ms-2 bg-white border border-red-100 text-red-400">
                                    La cita ha sido cancelada
                                </div>
                            @endif
                            
                            @if (in_array($cita->status, ['aceptada', 'completada']))
                                <a href="{{ route('cita.chat-paciente', $cita->id) }}" class="rounded-lg text-sm font-semibold py-2 px-4 ms-2 bg-white border border-blue-100 text-blue-400 hover:text-blue-400 hover:bg-blue-100">
                                    Ver chat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
