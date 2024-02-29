@props(['level' => 'info'])

<div {{ $attributes->merge(['class' => "input-detail input-detail-" . $level]) }}>
    {{ $slot }}
</div>
