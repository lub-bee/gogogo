@props(['id', 'class' => ''])

<section id="{{ $id }}" class="{{ "top-section " . $class }}">
    {{ $slot }}
</section>
