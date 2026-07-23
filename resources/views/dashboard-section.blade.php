@extends('layouts.dashboard')

@section('title', $title . " — LogIN")

@section('content')
<div class="space-y-6">
    <div>
        <nav class="text-sm text-slate-400">
            <a href="{{ route('dashboard') }}" class="hover:text-brand-600">Tableau de bord</a>
            <span class="mx-2">/</span>
            <span class="text-slate-500">{{ $group }}</span>
            <span class="mx-2">/</span>
            <span class="text-slate-600 font-medium">{{ $title }}</span>
        </nav>
        <h1 class="mt-2 font-serif text-3xl font-bold text-slate-900">{{ $title }}</h1>
    </div>

    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-12 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
        </div>
        <h2 class="mt-5 font-serif text-2xl font-bold text-slate-900">{{ $title }}</h2>
        <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto">Module « {{ $group }} » de la plateforme LogIN. Cette interface sera connectée à vos données métier.</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition">
            ← Retour au tableau de bord
        </a>
    </div>
</div>
@endsection
