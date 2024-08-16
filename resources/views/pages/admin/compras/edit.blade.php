<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Editar compra</h2>
                    <form method="POST" action="{{ route('compras.update', $compra->id) }}" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="producto_id" :value="__('Producto')" />
                            <x-select-input id="producto_id" class="block mt-1 w-full" name="producto_id" :value="old('producto_id')" required>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}" {{ old('producto_id', $compra->producto_id) == $producto->id ? 'selected' : '' }}> {{ $producto->nombre }} </option>
                                @endforeach
                            </x-select-input>
                            <x-individual-input-error  :messages="$errors->get('producto_id')" class="mt-2" />
                        </div> 

                        <div class="mb-4">
                            <x-label for="cantidad" :value="__('Cantidad')" />
                            <x-input id="cantidad" class="block mt-1 w-full" type="number" step="1" name="cantidad" :value="old('cantidad', $compra->cantidad)" />
                            <x-individual-input-error  :messages="$errors->get('cantidad')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="precio" :value="__('Precio')" />
                            <x-input id="precio" class="block mt-1 w-full" type="number" step="1" name="precio" :value="old('precio', $compra->precio)" />
                            <x-individual-input-error  :messages="$errors->get('precio')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="fecha_compra" :value="__('Fecha de Compra')" />
                            <x-datepicker id="fecha_compra" class="block w-full" name="fecha_compra" :value="old('fecha_compra', $compra->fecha_compra)" />
                            <x-individual-input-error  :messages="$errors->get('fecha_compra')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Actualizar Compra') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>