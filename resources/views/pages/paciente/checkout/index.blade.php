<x-app-layout>
    <div class="relative isolate flex items-center gap-x-6 overflow-hidden bg-gray-50 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
        <div class="absolute left-[max(-7rem,calc(50%-52rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
            <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ff7070] to-[#d61515] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
        </div>
        <div class="absolute left-[max(45rem,calc(50%+8rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
            <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ee6a6a] to-[#e4201a] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
        </div>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
            <p class="text-sm leading-6 text-gray-900">
                <strong class="font-semibold">
                    Recuerda
                </strong>
                <svg viewBox="0 0 2 2" class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true"><circle cx="1" cy="1" r="1" /></svg>
                Por motivos de seguridad los medicamentos no pueden ser enviados a domicilio 
            </p>
        </div>
        <div class="flex flex-1 justify-end"></div>
    </div>
      
    <div class="py-8 antialiased  md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
          <div class="mx-auto max-w-5xl">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Finalizar compra</h2>
      
            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
              <form class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm  sm:p-6 lg:max-w-xl lg:p-8" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="mb-6 grid grid-cols-2 gap-4">
                  <div class="col-span-2 sm:col-span-1">
                    <x-label for="full_name"> Nombre completo</x-label>
                    <x-input id="full_name" name="full_name" placeholder="Bonnie Green" required />
                    <x-input-error for="full_name" />
                </div>
      
                  <div class="col-span-2 sm:col-span-1">
                    <x-label for="card_number">Número de tarjeta</x-label>
                    <x-input id="card_number" name="card_number" placeholder="xxxx-xxxx-xxxx-xxxx" required />
                    <x-input-error for="card_number" />
                </div>
      
                  <div>
                    <x-label for="card_expiration">Fecha de expiración</x-label>
                    <x-input id="card_expiration" name="card_expiration" placeholder="12/23" required />
                    <x-input-error for="card_expiration" />
                  </div>

                  <div>
                    <x-label for="card_cvv">CVV</x-label>
                    <x-input id="card_cvv" name="card_cvv"  placeholder="123" pattern="^[0-9]{3,4}$" required />
                    <x-input-error for="card_cvv" />
                  </div>
                </div>
                    
                <x-button class="w-full justify-center mt-4">
                    <a href="" class="">Terminar compra</a>
                </x-button>
            </form>
      
              <div class="mt-6 grow sm:mt-8 lg:mt-0">
                <div class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6 ">
                  
                    <div class="space-y-2">
                        @foreach ($productos as $producto)
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-900 ">{{ $producto->nombre }} x {{ $producto->pivot->cantidad }}</dt>
                                <dd class="text-base font-medium text-gray-900 ">${{ $producto->precio_venta }}</dd>
                            </dl>   
                        @endforeach
                    </div>
                  
                    <div class="space-y-2">
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-base font-normal text-gray-500 ">Subtotal</dt>
                      <dd class="text-base font-medium text-gray-900 ">${{ $subtotal }}</dd>
                    </dl>
            
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-base font-normal text-gray-500 ">IVA</dt>
                      <dd class="text-base font-medium text-gray-900 ">${{ $iva }}</dd>
                    </dl>
                  </div>
      
                  <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 ">
                    <dt class="text-base font-bold text-gray-900 ">Total</dt>
                    <dd class="text-base font-bold text-gray-900 ">${{ $total }}</dd>
                  </dl>
                </div>
      
                <div class="mt-6 flex items-center justify-center gap-8">
                  <img class="h-8 w-auto" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg" alt="" />
                  <img class="h-8 w-auto" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard.svg" alt="" />
                </div>
              </div>
            </div>
            <p class="mt-6 text-center text-gray-500  sm:mt-8 lg:text-left">
                Pago procesado por <a href="#" title="" class="font-medium text-primary-700 underline hover:no-underline ">Stripe</a> para <a href="#" title="" class="font-medium text-primary-700 underline hover:no-underline ">MedicalCare</a>
          </div>
        </div>
      </div>
</x-app-layout>
