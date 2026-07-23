@extends('layouts.dashboard')

@section('title', "Tableau de bord — LogIN")

@section('content')
<div class="space-y-6">

    <div class="mb-2">
        <h1 class="font-serif text-3xl font-bold italic tracking-tight text-navy-900 sm:text-4xl">
            Cartes <span class="not-italic text-gold-600">Analytiques</span>
        </h1>
        <div class="mt-2 h-[3px] w-40 rounded-full bg-gradient-to-r from-gold-400 via-gold-500 to-transparent shadow-[0_0_12px_rgba(196,146,47,0.55)]"></div>
    </div>

    <div class="flex w-full gap-3">
        @foreach ($stats as $s)
            <article class="stat-card group relative min-w-0 flex-1 overflow-hidden rounded-xl bg-gradient-to-br {{ $s['card'] }} shadow-lg ring-1 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                {{-- Barre couleur --}}
                <span class="absolute inset-y-0 left-0 w-1.5 {{ $s['accent'] }}"></span>

                {{-- Orbes lumineux --}}
                <div class="pointer-events-none absolute -right-5 -top-6 h-20 w-20 rounded-full {{ $s['orb'] }} blur-2xl transition duration-500 group-hover:scale-125 group-hover:opacity-80"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-4 h-16 w-16 rounded-full {{ $s['orb'] }} blur-2xl opacity-60"></div>

                {{-- Reflet animé --}}
                <div class="stat-shimmer pointer-events-none absolute inset-0 opacity-0 transition duration-300 group-hover:opacity-100"></div>

                <div class="relative px-3 py-2.5 pl-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg shadow-md {{ $s['iconBg'] }} transition duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                        </div>
                        <span class="inline-flex items-center gap-0.5 rounded-md px-1.5 py-0.5 text-[10px] font-bold ring-1 {{ $s['badge'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['up'] ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/></svg>
                            {{ $s['change'] }}
                        </span>
                    </div>

                    <p class="mt-2 truncate text-[10px] font-semibold uppercase tracking-[0.08em] text-navy-600">{{ $s['label'] }}</p>
                    <p class="mt-0.5 truncate font-sans text-base font-bold tracking-tight text-navy-950">
                        {{ $s['value'] }}
                        @if (!empty($s['unit']))
                            <span class="text-[11px] font-semibold text-navy-600">{{ $s['unit'] }}</span>
                        @endif
                    </p>
                </div>
            </article>
        @endforeach
    </div>

</div>
@endsection
