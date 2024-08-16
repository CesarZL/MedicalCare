<x-guest-layout>
    <div class="absolute inset-0 bg-gray-300">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1535.7000640988651!2d-99.07769846779745!3d23.728440861913693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8679518d51b27fb7%3A0x9d1cef8439f1e521!2sCampus%20UPV!5e0!3m2!1ses-419!2smx!4v1723131894119!5m2!1ses-419!2smx" 
        width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" title="mapa" scrolling="no" style=""></iframe>
    </div>
    <div class="container px-5 py-24 mx-auto flex">
        <div
            class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 relative z-10 shadow-md">
            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Comentarios</h2>
            <p class="leading-relaxed mb-5 text-gray-600">¿Tienes alguna duda? Contáctanos</p>
            <div class="relative mb-4">
                <x-label class="leading-7 text-sm text-gray-600" for="email" value="Correo electrónico" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
            
            </div>
            <div class="relative mb-4">
                <x-label class="leading-7 text-sm text-gray-600" for="message" value="Mensaje" />
                <textarea id="message" name="message"
                    class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
            </div>

            <x-button>Enviar</x-button>

            <p class="text-xs text-gray-500 mt-3">No recibirás mensajes no deseados</p>
        </div>
    </div>
</x-guest-layout>