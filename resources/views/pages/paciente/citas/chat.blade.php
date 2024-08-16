<x-app-layout>
    <div class="flex justify-center items-center py-5 h-full">
        <div class="bg-white shadow-lg rounded-lg p-3 max-w-2xl w-full flex flex-col h-full">

            <!-- Chat -->
            <ul id="chat-messages" class="list-none space-y-4 bg-gray-50 p-3 rounded-lg flex-grow overflow-y-auto h-96">
                @foreach ($cita->mensajes as $mensaje)
                    <li class="{{ $mensaje->usuario_id === auth()->id() ? 'flex ms-auto gap-x-2 sm:gap-x-4 my-4' : 'max-w-lg flex gap-x-2 sm:gap-x-4 me-11' }}">
                        <div class="{{ $mensaje->usuario_id === auth()->id() ? 'grow text-end space-y-3' : 'bg-white border border-gray-200 rounded-e-lg rounded-t-lg p-4 space-y-3' }}">
                            <div class="{{ $mensaje->usuario_id === auth()->id() ? 'inline-block bg-blue-400 rounded-s-lg rounded-t-lg p-4 shadow-sm' : '' }}">
                                <p class="text-sm {{ $mensaje->usuario_id === auth()->id() ? 'text-white' : 'text-gray-800' }}">
                                    {{ $mensaje->mensaje }}
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- End Chat -->

            <div class="mt-3">
                <form id="chat-form" action="{{ route('mensaje.enviar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                    <div class="flex items-center p-3 rounded-lg bg-gray-50">
                        <textarea id="chat-message" name="mensaje" rows="1" class="block p-2.5 w-full bg-white rounded-lg text-sm border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Escribe algo..."></textarea>
                        <button type="submit" class="py-2.5 ml-3 px-4 inline-flex justify-center rounded-lg text-sm font-semibold bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chat-form');
        const chatMessageInput = document.getElementById('chat-message');
        const chatMessagesContainer = document.getElementById('chat-messages');

        // Función para hacer scroll hacia abajo
        function scrollToBottom() {
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }

        // Hacer scroll hacia abajo al cargar la página
        scrollToBottom();

        // Configuración de Laravel Echo
        Echo.channel('cita.' + {{ $cita->id }})
            .listen('MessageSent', (event) => {
                const mensaje = event.mensaje;
                const mensajeHtml = `<li class="${mensaje.usuario_id === {{ auth()->id() }} ? 'flex ms-auto gap-x-2 sm:gap-x-4 my-4' : 'max-w-lg flex gap-x-2 sm:gap-x-4 me-11'}">
                    <div class="${mensaje.usuario_id === {{ auth()->id() }} ? 'grow text-end space-y-3' : 'bg-white border border-gray-200 rounded-e-lg rounded-t-lg p-4 space-y-3'}">
                        <div class="${mensaje.usuario_id === {{ auth()->id() }} ? 'inline-block bg-blue-400 rounded-s-lg rounded-t-lg p-4 shadow-sm' : ''}">
                            <p class="text-sm ${mensaje.usuario_id === {{ auth()->id() }} ? 'text-white' : 'text-gray-800'}">
                                ${mensaje.mensaje}
                            </p>
                        </div>
                    </div>
                </li>`;
                chatMessagesContainer.innerHTML += mensajeHtml;
                scrollToBottom(); // Hacer scroll hacia abajo al agregar un nuevo mensaje
            });

        // Manejar el envío del formulario
        chatForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(chatForm);

            axios.post(chatForm.action, formData)
                .then(response => {
                    const mensaje = response.data;
                    const mensajeHtml = `<li class="flex ms-auto gap-x-2 sm:gap-x-4 my-4">
                        <div class="grow text-end space-y-3">
                            <div class="inline-block bg-blue-400 rounded-s-lg rounded-t-lg p-4 shadow-sm">
                                <p class="text-sm text-white">
                                    ${mensaje.mensaje}
                                </p>
                            </div>
                        </div>
                    </li>`;
                    chatMessagesContainer.innerHTML += mensajeHtml;
                    chatMessageInput.value = ''; // Limpiar el campo de entrada
                    scrollToBottom(); // Hacer scroll hacia abajo al enviar un mensaje
                })
                .catch(error => {
                    console.error('Error al enviar el mensaje:', error);
                });
        });

        // Enviar mensaje al presionar Enter
        chatMessageInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });
    </script>
</x-app-layout>
