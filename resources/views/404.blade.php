<x-app-layout>
<div class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="text-center">
        <p class="text-base font-semibold text-blue-500">404</p>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Página no encontrada</h1>
        <p class="mt-6 text-base leading-7 text-gray-600">La página que estás buscando no existe. Por favor, verifica la URL.</p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="{{ route('welcome') }}" class="rounded-md bg-blue-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Volver a inicio</a>
        </div>
    </div>
</div>
</x-app-layout>
