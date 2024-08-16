@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold leading-6 text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
