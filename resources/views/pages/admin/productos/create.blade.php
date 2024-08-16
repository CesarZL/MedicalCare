<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Crear producto</h2>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('productos.store') }}">
                        @csrf

                        <div class="pb-4">
                            <img id="preview-image" class="mt-2 w-full h-auto max-w-md mx-auto object-cover rounded-lg aspect-square border border-gray-300 hidden">
                        </div>

                        <div class="mb-4">
                            <x-label for="imagen" :value="__('Imagen')" />
                            <input type="file" accept="image/jpeg, image/jpg, image/png"  name="imagen" id="imagen" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out" onchange="previewImage(event)">
                            <x-individual-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="nombre" :value="__('Nombre')" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"  autofocus />
                            <x-individual-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="categoria_id" :value="__('Categoría')" />
                            <x-select-input id="categoria_id" class="block mt-1 w-full" name="categoria_id">
                                <option value="" disabled selected>{{ __('Selecciona una categoría') }}</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </x-select-input>
                            
                            <x-individual-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="precio_venta" :value="__('Precio de venta')" />
                            <x-input id="precio_venta" class="block mt-1 w-full" type="number" name="precio_venta" :value="old('precio_venta')"  />
                            <x-individual-input-error :messages="$errors->get('precio_venta')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="marca" :value="__('Marca')" />
                            <x-input id="marca" class="block mt-1 w-full" type="text" name="marca" :value="old('marca')"  />
                            <x-individual-input-error :messages="$errors->get('marca')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="descripcion" :value="__('Descripción')" />
                            <x-textarea-input id="descripcion" class="block mt-1 w-full" name="descripcion" :value="old('descripcion')"  />
                            <x-individual-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Crear producto') }}
                            </x-button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</x-app-layout>