<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Productos y medicamentos
      </h2>
  </x-slot>

  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-16 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">Contamos con gran variedad de productos y medicamentos</h2>
      <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          @foreach ($productos as $producto)
          <div class="relative flex w-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
            <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-md" href="#">
                <img class="object-cover w-full h-full"
                    src="{{ asset($producto->imagen) }}" 
                    alt="product image" />
            </div>
            <div class="mt-4 mx-3 mb-3">
                <h5 class="tracking-tight text-slate-900">{{ $producto->nombre }}</h5>
                <div class="mt-2 mb-5 flex items-center justify-between">
                    <p><span class="text-xl font-bold text-slate-900">${{ $producto->precio_venta }}</span></p>
                    <div class="flex items-center">
                        <span class="mr-2 ml-3 rounded bg-blue-200 text-blue-500 px-2.5 py-0.5 text-xs font-semibold">{{ $producto->marca }}</span>
                    </div>
                </div>
                <a href="{{ route('productos.show', $producto) }}"
                    class="inline-flex justify-center rounded-md text-sm font-semibold py-2.5 px-4 bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200 w-full">
                    Ver producto
                </a>
            </div>
        </div>
          @endforeach
      </div>
  </div>
</x-app-layout>