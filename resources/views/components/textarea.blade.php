<textarea {!! $attributes->merge([
    'class' => 'bg-gray-200 resize-none w-full rounded-xl mt-1 mb-2 h-32',
]) !!}> {{ $slot }} </textarea>
