<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Editar médico</h2>
                    <form method="POST" action="{{ route('medicos.update', $medico->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="pb-4">
                            @if($medico->imagen)
                                <img id="preview-image" class="mt-2 w-full h-auto max-w-md mx-auto object-cover rounded-lg aspect-square border border-gray-300" src="{{ asset($medico->imagen) }}" />
                            @else
                                <img id="preview-image" class="mt-2 w-full h-auto max-w-md mx-auto object-cover rounded-lg aspect-square border border-gray-300 hidden">
                            @endif
                        </div>

                        <div class="mb-4">
                            <x-label for="imagen" :value="__('Imagen')" />
                            <input type="file" accept="image/jpeg, image/jpg, image/png" name="imagen" id="imagen" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out" onchange="previewImage(event)">
                            <x-individual-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="name" :value="__('Nombre')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $medico->user->name)" autofocus />
                            <x-individual-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="curp" :value="__('CURP')" />
                            <x-input id="curp" class="block mt-1 w-full" type="text" name="curp" :value="old('curp', $medico->user->curp)" />
                            <x-individual-input-error :messages="$errors->get('curp')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="cedula" :value="__('Cédula profesional')" />
                            <x-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula', $medico->cedula)" />
                            <x-individual-input-error :messages="$errors->get('cedula')" class="mt-2" />
                        </div>                        

                        <div class="mb-4">
                            <x-label for="especialidad" :value="__('Especialidad')" />
                            <x-input id="especialidad" class="block mt-1 w-full" type="text" name="especialidad" :value="old('especialidad', $medico->especialidad)" />
                            <x-individual-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="email" :value="__('Correo')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $medico->user->email)" />
                            <x-individual-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="telefono" :value="__('Teléfono')" />
                            <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono', $medico->user->telefono)" />
                            <x-individual-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="direccion" :value="__('Dirección')" />
                            <x-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion', $medico->direccion)" />
                            <x-individual-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>
                        
                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Actualizar médico') }}
                            </x-button>
                        </div>

                        <x-validation-errors class="mb-4 mt-5 text-center" />
                        
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
