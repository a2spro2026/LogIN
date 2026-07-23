@extends('layouts.app')

@section('title', 'Connexion — LogIN')

@section('content')
<div class="relative min-h-screen overflow-hidden bg-navy-50">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(196,146,47,0.12),transparent_50%),radial-gradient(ellipse_at_bottom_left,rgba(15,39,68,0.08),transparent_45%)]"></div>

    <div class="relative mx-auto flex min-h-screen max-w-6xl items-center px-4 py-10 sm:px-6">
        <div class="grid w-full overflow-hidden rounded-3xl bg-white shadow-2xl shadow-navy-900/10 ring-1 ring-navy-100 lg:grid-cols-2">

            <div class="relative hidden min-h-[620px] lg:block">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80"
                     alt="Villa moderne à louer"
                     class="absolute inset-0 h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950/90 via-navy-950/45 to-navy-950/25"></div>
                <div class="relative flex h-full flex-col justify-between p-10 text-white">
                    <a href="{{ url('/') }}">
                        <x-logo class="h-10 w-10" :show-wordmark="true" :inverse="true" />
                    </a>
                    <div>
                        <h2 class="font-sans text-3xl font-bold leading-tight tracking-tight">
                            Bienvenue chez Log<span class="text-gold-400">IN</span>
                        </h2>
                        <p class="mt-3 max-w-sm text-sm leading-relaxed text-white/75">
                            Accédez à votre espace pour gérer vos biens, vos locataires et vos dossiers de location.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center p-8 sm:p-12">
                <div class="w-full max-w-sm">
                    <div class="mb-8 lg:hidden">
                        <a href="{{ url('/') }}">
                            <x-logo class="h-9 w-9" :show-wordmark="true" />
                        </a>
                    </div>

                    <h1 class="font-sans text-3xl font-bold tracking-tight text-navy-900">Se connecter</h1>
                    <p class="mt-2 text-sm text-navy-500">Entrez vos identifiants pour accéder à votre compte LogIN.</p>

                    @if ($errors->any())
                        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}" class="mt-7 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-navy-700">Adresse e-mail</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-navy-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                       placeholder="vous@login.ma"
                                       class="w-full rounded-xl border border-navy-200 bg-navy-50/50 py-3 pl-11 pr-4 text-sm text-navy-900 placeholder-navy-300 outline-none transition focus:border-gold-400 focus:bg-white focus:ring-4 focus:ring-gold-100">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-navy-700">Mot de passe</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-navy-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                </span>
                                <input id="password" name="password" type="password" required
                                       placeholder="••••••••"
                                       class="w-full rounded-xl border border-navy-200 bg-navy-50/50 py-3 pl-11 pr-4 text-sm text-navy-900 placeholder-navy-300 outline-none transition focus:border-gold-400 focus:bg-white focus:ring-4 focus:ring-gold-100">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex select-none items-center gap-2 text-sm text-navy-600">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-navy-300 text-gold-600 focus:ring-gold-400">
                                Se souvenir de moi
                            </label>
                        </div>

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-navy-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800 active:scale-[.99]">
                            Se connecter
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </form>

                    <div class="mt-6 rounded-xl border border-navy-100 bg-navy-50 px-4 py-3 text-xs text-navy-600">
                        <p class="mb-0.5 font-semibold text-navy-800">Compte superadmin</p>
                        <p>E-mail : <span class="font-mono">zerraguiabdelilah@login.com</span> · Mot de passe : <span class="font-mono">password</span></p>
                    </div>

                    <p class="mt-6 text-center text-sm text-navy-500">
                        <a href="{{ url('/') }}" class="font-medium text-navy-700 transition hover:text-gold-600">← Retour à l'accueil</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
