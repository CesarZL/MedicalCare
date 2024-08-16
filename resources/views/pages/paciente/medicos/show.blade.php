<x-app-layout>
    <div class="relative py-16">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mx-auto max-md:px-2 ">
                <div class="h-full max-lg:mx-auto">
                    <img src="{{asset($medico->imagen)}}" alt="{{ $medico->user->name }}" class="max-lg:mx-auto rounded-2xl ml-auto shadow-md">
                </div>
                <div class="w-full lg:pr-8 pr-0 xl:justify-start justify-center flex items-center max-lg:pb-10">
                    <div class="w-full max-w-2xl bg-white p-8 rounded-2xl">
                        <p class="text-lg font-medium leading-8 text-blue-600">{{ $medico->especialidad }}</p>
                        <h2 class="font-bold text-3xl leading-10 text-gray-900 mb-4 capitalize">{{ $medico->user->name }}</h2>
                        <!-- Tabla de Citas Disponibles -->
                        <div class="overflow-x-auto rounded-xl">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-blue-600 text-white">
                                    <tr>
                                        @foreach ($diasSemana as $dia)
                                            <th class="py-3 px-4 text-center">{{ $dia }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($horas as $hora)
                                        <tr>
                                            @foreach ($diasSemana as $dia)
                                                <td class="border-t border-gray-200 text-center py-3 px-4">
                                                    @if(isset($citasDisponibles[$dia][$hora]))
                                                        <form method="POST" action="{{ route('citas.reservar') }}">
                                                            @csrf
                                                            <input type="hidden" name="medico_id" value="{{ $medico_id }}">
                                                            <input type="hidden" name="fecha_hora" value="{{ $citasDisponibles[$dia][$hora] }}">
                                                            <button type="submit" class="py-2 px-4 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition duration-300">
                                                                {{ $hora }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400">{{ $hora }}</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Fin de la Tabla de Citas Disponibles -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>