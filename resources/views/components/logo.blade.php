@props([
    'class' => 'h-9 w-9',
    'showWordmark' => false,
    'inverse' => false,
])

@php
    $titleClass = $inverse ? 'text-white' : 'text-navy-900';
    $subClass = $inverse ? 'text-white/70' : 'text-navy-500';
    $accentClass = $inverse ? 'text-gold-400' : 'text-gold-500';
@endphp

@php
$mark = <<<'SVG'
<svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <path d="M46 14h7v12l-7 6V14Z" fill="#C4922F"/>
  <path d="M32 6 6 28v30h52V28L32 6Z" fill="#C4922F"/>
  <path d="M23 58V39.5a9 9 0 0 1 18 0V58H23Z" fill="#0A1A2E"/>
  <circle cx="32" cy="37.5" r="3.1" fill="#C4922F"/>
  <path d="M30.6 39.8h2.8v7.6a1.4 1.4 0 0 1-2.8 0v-7.6Z" fill="#C4922F"/>
</svg>
SVG;
@endphp

@if ($showWordmark)
    <span {{ $attributes->class('inline-flex items-center gap-2.5') }}>
        <span class="{{ $class }} block shrink-0 [&>svg]:h-full [&>svg]:w-full">{!! $mark !!}</span>
        <span class="flex flex-col leading-none">
            <span class="font-sans text-[1.35rem] font-bold tracking-tight {{ $titleClass }}">Log<span class="{{ $accentClass }}">IN</span></span>
            <span class="mt-1 text-[0.58rem] font-semibold uppercase tracking-[0.18em] {{ $subClass }}">Location immobilière</span>
        </span>
    </span>
@else
    <span {{ $attributes->merge(['class' => $class . ' inline-block [&>svg]:h-full [&>svg]:w-full']) }}>{!! $mark !!}</span>
@endif
