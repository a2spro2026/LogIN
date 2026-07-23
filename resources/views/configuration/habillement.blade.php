@extends('layouts.dashboard')

@section('title', 'Habillement — LogIN')

@section('content')
@php
    $playback = $habillement->videoPlayback();
@endphp

<div class="space-y-6">
    <div>
        <nav class="text-sm text-navy-400">
            <a href="{{ route('dashboard') }}" class="hover:text-navy-700">Tableau de bord</a>
            <span class="mx-2">/</span>
            <span class="text-navy-500">Configuration</span>
            <span class="mx-2">/</span>
            <span class="font-medium text-navy-700">Habillement</span>
        </nav>
        <h1 class="mt-2 font-sans text-2xl font-bold text-navy-900">Habillement</h1>
        <p class="mt-1 text-sm text-navy-500">Titre, description et vidéo publicitaire du hero d’accueil.</p>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <ul class="list-disc space-y-1 pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('configuration.habillement.update') }}" enctype="multipart/form-data"
          class="max-w-2xl space-y-5 rounded-2xl bg-white p-6 ring-1 ring-navy-100 sm:p-8">
        @csrf
        @method('PUT')

        <div>
            <label for="titre" class="mb-1.5 block text-sm font-semibold text-navy-800">Titre</label>
            <input id="titre" name="titre" type="text" value="{{ old('titre', $habillement->titre) }}"
                   placeholder="La meilleure façon de louer votre futur chez-vous"
                   class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 text-sm text-navy-900 outline-none ring-gold-400/40 transition focus:border-gold-500 focus:ring-2">
        </div>

        <div>
            <label for="description" class="mb-1.5 block text-sm font-semibold text-navy-800">Description</label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Des appartements, villas et bureaux sélectionnés…"
                      class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 text-sm text-navy-900 outline-none ring-gold-400/40 transition focus:border-gold-500 focus:ring-2">{{ old('description', $habillement->description) }}</textarea>
        </div>

        <div>
            <label for="video" class="mb-1.5 block text-sm font-semibold text-navy-800">Importer Vidéo</label>
            <input id="video" name="video" type="file" accept="video/mp4,video/webm,video/quicktime,video/*"
                   class="block w-full text-sm text-navy-600 file:mr-4 file:rounded-lg file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
            <p class="mt-1.5 text-xs text-navy-400">MP4 / WebM / MOV — max. 100 Mo</p>
            @if ($habillement->video_path)
                <p class="mt-2 text-xs text-emerald-700">Fichier actuel : {{ basename($habillement->video_path) }}</p>
            @endif
        </div>

        <div>
            <label for="video_url" class="mb-1.5 block text-sm font-semibold text-navy-800">Coller URL</label>
            <input id="video_url" name="video_url" type="url" value="{{ old('video_url', $habillement->video_url) }}"
                   placeholder="https://… (MP4, YouTube ou Vimeo)"
                   class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 text-sm text-navy-900 outline-none ring-gold-400/40 transition focus:border-gold-500 focus:ring-2">
        </div>

        @if ($playback)
            <div class="overflow-hidden rounded-xl bg-navy-950 ring-1 ring-navy-200">
                <p class="border-b border-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gold-400">Aperçu</p>
                <div class="aspect-video bg-black">
                    @if ($playback['type'] === 'embed')
                        <iframe src="{{ $playback['src'] }}" class="h-full w-full" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    @else
                        <video class="h-full w-full object-contain" controls playsinline src="{{ $playback['src'] }}"></video>
                    @endif
                </div>
            </div>
            <label class="inline-flex items-center gap-2 text-sm text-navy-600">
                <input type="checkbox" name="clear_video" value="1" class="rounded border-navy-300 text-navy-900 focus:ring-gold-400">
                Supprimer la vidéo actuelle
            </label>
        @endif

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-navy-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-navy-800">
                Valider
            </button>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center rounded-xl border border-navy-200 bg-white px-6 py-3 text-sm font-semibold text-navy-700 transition hover:bg-navy-50">
                Annuler
            </a>
            <a href="{{ url('/') }}" target="_blank" rel="noopener"
               class="ml-auto text-sm font-medium text-gold-700 hover:text-gold-800">
                Voir l’accueil →
            </a>
        </div>
    </form>
</div>
@endsection
