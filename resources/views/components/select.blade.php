@props(['value'])

<select {{ $attributes->merge(['class' => "block mt-1 w-full rounded-xl"])}}>
    {{ $value ?? $slot }}
</select>