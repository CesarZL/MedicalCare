{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
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

        <form class="w-full max-w-sm" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"/>
            </div>

            <x-button> Iniciar sesión </x-button>

            @if (session('status'))
                <div class="mb-4 mt-5 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif
            
            <x-validation-errors class="mb-4 mt-5 text-center" />

        </form>
    </div>
    <footer class="relative shrink-0">
        <div class="space-y-4 text-sm text-gray-900 sm:flex sm:items-center sm:justify-center sm:space-x-4 sm:space-y-0">
            <p class="text-center sm:text-left">¿Recordaste tu contraseña?</p>
            <a class="inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 text-slate-900 ring-1 ring-slate-900/10 hover:ring-slate-900/20"
                href="{{ route('login') }}">
                <span>Inicia sesión<span class="ml-2" aria-hidden="true">→</span></span>
            </a>
        </div>
    </footer>
</x-guest-layout>
