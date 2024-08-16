<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">
                        Ver categoria
                    </h2>
                    <div class="mb-4">
                        <x-label for="nombre" :value="__('Nombre')" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$categoria->nombre" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>