@props(['disabled' => false])

<table
{{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'w-full border border-black border-collapse'])}}> {{$slot}}
</table>