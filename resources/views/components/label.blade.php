@props(['value'])

<label {{ $attributes->merge(['class' => 'text-white block font-medium text-lg text-gray-700'])}}>
    {{ $value ?? $slot }}
</label>
