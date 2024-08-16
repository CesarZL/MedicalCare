<x-app-layout>
    <div class="py-12">
        <div class="max-w-full px-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold leading-tight">Mis compras</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                        @foreach ($ventas as $venta)
                            <div class="bg-gray-50 shadow-md rounded-lg p-4 border border-gray-100">
                                <h3 class="text-lg font-semibold">Compra #{{ $venta->id }}</h3>
                                <p class="text-gray-600">Fecha de compra: <strong>{{ $venta->fecha_de_venta }}</strong></p>
                                <p class="text-gray-600">Subtotal: <strong>${{ number_format($venta->subtotal, 2) }}</strong></p>
                                <p class="text-gray-600">IVA: <strong>${{ number_format($venta->IVA, 2) }}</strong></p>
                                <p class="text-gray-600">Total: <strong>${{ number_format($venta->total, 2) }}</strong></p>
                                <div class="mt-4 flex flex-col space-y-2">
                                    <a href="{{ route('compras.mis-compras.detalle', $venta->id) }}" class="block text-center py-2.5 px-4 justify-center rounded-lg text-sm font-semibold bg-green-400 text-white hover:text-green-500 hover:bg-green-200">Ver detalles</a>
                                    <a href="{{ route('compras.mis-compras.pdf', $venta->id) }}" class="block text-center py-2.5 px-4 justify-center rounded-lg text-sm font-semibold bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200">PDF</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
