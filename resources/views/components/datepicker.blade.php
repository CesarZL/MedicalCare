<div class="relative">
    <input {!! $attributes->merge(['class' => 'datepicker pl-9 w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out']) !!} placeholder="Selecciona una fecha" data-class="flatpickr-right" >
    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
        <svg class="w-4 h-4 fill-current text-slate-500 dark:text-slate-400 ml-3" viewBox="0 0 16 16">
            <path d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
        </svg>
    </div>
</div>