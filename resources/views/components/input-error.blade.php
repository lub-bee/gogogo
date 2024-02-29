@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'border border-red-500 bg-red-100 text-red-500 px-4 py-2']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
