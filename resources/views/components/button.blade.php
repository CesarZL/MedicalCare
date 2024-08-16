<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 bg-blue-400 text-white hover:text-blue-500 hover:bg-blue-200 w-full']) }}>
    {{ $slot }}
</button>
