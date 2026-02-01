@props(['text'])

<div {{ $attributes->merge([
    'class' => 'icontextanimationhero'
]) }}>
    <div class="icon">
        {{ $slot }}
    </div>
    <div class="text">{{ $text }}</div>
</div>