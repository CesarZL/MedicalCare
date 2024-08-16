{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

<x-guest-layout>
    <img src="{{ asset('img/auth.jpg') }}" class="absolute inset-0 object-cover w-full h-full" />
    <div class="absolute inset-0 text-slate-900/[0.10] [mask-image:linear-gradient(to_bottom_left,white,transparent,transparent)]">
        <svg class="absolute inset-0 h-full w-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-bg" width="32" height="32" patternUnits="userSpaceOnUse" x="100%"
                    patternTransform="translate(0 -1)">
                    <path d="M0 32V.5H32" fill="none" stroke="currentColor"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-bg)"></rect>
        </svg>
    </div>
    <div class="relative flex flex-1 flex-col items-center justify-center pb-16 pt-12">
            <x-application-logo class="w-24 h-24 text-sky-400" />

        <form class="w-full max-w-xl" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <x-label for="email" value="Correo electrónico" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"/>
            </div>

            <div class="mb-4">
                <x-label for="name" value="Nombre" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"/>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="mb-4">
                    <x-label for="telefono" value="Teléfono" />
                    <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"/>
                </div>

                <div class="mb-4">
                    <x-label for="curp" value="CURP" />
                    <x-input id="curp" class="block mt-1 w-full" type="text" name="curp" :value="old('curp')"/>
                </div>

                <div class="mb-4">
                    <x-label for="sexo" value="Sexo" />
                    <x-select-input id="sexo" class="block mt-1 w-full" name="sexo">
                        <option value="" disabled selected>{{ __('Selecciona una opción') }}</option>
                        <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="no_binario" {{ old('sexo') == 'no_binario' ? 'selected' : '' }}>No binario</option>
                    </x-select-input>
                </div>

                <div class="mb-4">
                    <x-label for="tipo_sangre" value="Tipo de sangre" />
                    <x-select-input id="tipo_sangre" class="block mt-1 w-full" name="tipo_sangre">
                        <option value="" disabled selected>{{ __('Selecciona una opción') }}</option>
                        <option value="A+" {{ old('tipo_sangre') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('tipo_sangre') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('tipo_sangre') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('tipo_sangre') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('tipo_sangre') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('tipo_sangre') == 'O-' ? 'selected' : '' }}>O-</option>
                    </x-select-input>
                </div>

                <div class="mb-4">
                    <x-label for="password" value="Contraseña" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
                </div>

                <div class="mb-4">
                    <x-label for="password_confirmation" value="Confirmar contraseña" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"/>
                </div>               
            </div>

            <x-button> Crear cuenta </x-button>
            
            <x-validation-errors class="mb-4 mt-5 text-center" />

        </form>
    </div>
    <footer class="relative shrink-0">
        <div class="space-y-4 text-sm text-gray-900 sm:flex sm:items-center sm:justify-center sm:space-x-4 sm:space-y-0">
            <p class="text-center sm:text-left">¿Ya tienes cuenta?</p>
            <a class="inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 text-slate-900 ring-1 ring-slate-900/10 hover:ring-slate-900/20"
                href="{{ route('login') }}">
                <span>Inicia sesión<span class="ml-2" aria-hidden="true">→</span></span>
            </a>
        </div>
    </footer>
</x-guest-layout>