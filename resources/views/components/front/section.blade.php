@props(['id', 'class' => ''])

<section id="{{ $id }}" class="{{ $class }}">
    {{ $slot }}
</section>
