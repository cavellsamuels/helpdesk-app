@props(['disabled' => false])

<h2 {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'text-white font-bold text-4xl pb-4 pt-2 underline',
]) !!}> {{$slot}} </h2>
