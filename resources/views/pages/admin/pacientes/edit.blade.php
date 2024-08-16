<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold leading-tight mb-4">Editar paciente</h2>
                    <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-label for="name" :value="__('Nombre')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $paciente->user->name)" autofocus />
                            <x-individual-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="email" :value="__('Correo')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $paciente->user->email)" />
                            <x-individual-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="telefono" :value="__('Teléfono')" />
                            <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono', $paciente->user->telefono)" />
                            <x-individual-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="curp" :value="__('CURP')" />
                            <x-input id="curp" class="block mt-1 w-full" type="text" name="curp" :value="old('curp', $paciente->user->curp)" />
                            <x-individual-input-error :messages="$errors->get('curp')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="sexo" :value="__('Sexo')" />
                            <x-select-input id="sexo" class="block mt-1 w-full" name="sexo">
                                <option value="" disabled>{{ __('Selecciona una opción') }}</option>
                                <option value="masculino" {{ old('sexo', $paciente->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('sexo', $paciente->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="no_binario" {{ old('sexo', $paciente->sexo) == 'no_binario' ? 'selected' : '' }}>No binario</option>
                            </x-select-input>
                            <x-individual-input-error :messages="$errors->get('sexo')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="tipo_sangre" :value="__('Tipo de sangre')" />
                            <x-select-input id="tipo_sangre" class="block mt-1 w-full" name="tipo_sangre">
                                <option value="" disabled>{{ __('Selecciona una opción') }}</option>
                                <option value="A+" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('tipo_sangre', $paciente->tipo_sangre) == 'O-' ? 'selected' : '' }}>O-</option>
                            </x-select-input>
                            <x-individual-input-error :messages="$errors->get('tipo_sangre')" class="mt-2" />
                        </div>
                        
                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Actualizar paciente') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
