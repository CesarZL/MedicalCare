<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Crear categoria</h2>
                    <form method="POST" action="{{ route('categorias.store') }}" novalidate>
                        @csrf
                        <div class="mb-4">
                            <x-label for="nombre" :value="__('Nombre')" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" autofocus />
                            <x-individual-input-error  :messages="$errors->get('nombre')" class="mt-2" />
                        </div>
                       
                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Crear categoria') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>