@props(['disabled' => false])

<h1 {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'font-medium leading-tight text-4xl mt-0 mb-6 text-white font-black underline font-sans',
]) !!}> {{$slot}} </h1>
