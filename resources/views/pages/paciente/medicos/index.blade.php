<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Médicos y especialistas
        </h2>
    </x-slot>

    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-16 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            Contamos con gran personal capacitado para atender tus necesidades
        </h2>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($medicos as $medico)
                <div class="relative flex w-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                    <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-md" href="#">
                        <img class="object-cover w-full h-full"
                            src="{{ asset($medico->imagen) }}"
                            alt="{{ $medico->user->name }}">
                    </div>
                    <div class="mx-3 my-3">
                        <h5 class="tracking-tight font-medium text-slate-900 my-3 text-center">
                            {{ $medico->user->name }}
                        </h5>
                        <div class="mb-4 flex items-center justify-center">
                            <div class="flex items-center">
                                <span class="rounded bg-blue-200 text-blue-500 px-2.5 py-0.5 text-xs font-semibold">
                                    {{ $medico->especialidad }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('citas.medico', $medico->id) }}"
                            class="inline-flex justify-center rounded-md text-sm font-semibold py-2.5 px-4 bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200 w-full">
                            Ver citas disponibles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>