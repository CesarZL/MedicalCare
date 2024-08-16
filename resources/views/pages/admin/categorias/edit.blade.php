<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Editar categoria</h2>
                    <form method="POST" action="{{ route('categorias.update', $categoria->id) }}" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-label for="nombre" :value="__('Nombre')" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $categoria->nombre)" />
                            <x-individual-input-error  :messages="$errors->get('nombre')" class="mt-2" />
                        </div>
                       
                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Editar categoria') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>