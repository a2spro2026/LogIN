@extends('layouts.app')

@section('title', 'LogIN — Location immobilière au Maroc')

@section('content')
@php
    $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan', 'Salé', 'Mohammedia'];
    $typesBiens = [
        'Appartements' => 'appartements',
        'Maisons Villas' => 'maisons',
        'Terrains' => 'terrains',
        'Magasins' => 'magasins',
    ];
    $servicesMenu = [
        'Transport' => 'transport',
        'Restaurants' => 'restaurants',
    ];
    $biens = [
        [
            'titre' => 'Appartement moderne à Maarif',
            'lieu' => 'Maarif, Casablanca',
            'chambres' => 2,
            'sdb' => 1,
            'surface' => 85,
            'prix' => '6 500',
            'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=900&q=80',
        ],
        [
            'titre' => 'Villa avec piscine à Bouskoura',
            'lieu' => 'Bouskoura, Casablanca',
            'chambres' => 4,
            'sdb' => 3,
            'surface' => 220,
            'prix' => '18 000',
            'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=900&q=80',
        ],
        [
            'titre' => 'Bureau équipé à Gauthier',
            'lieu' => 'Gauthier, Casablanca',
            'chambres' => 0,
            'sdb' => 1,
            'surface' => 65,
            'prix' => '9 200',
            'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=900&q=80',
        ],
        [
            'titre' => 'Appartement vue mer à Ain Diab',
            'lieu' => 'Ain Diab, Casablanca',
            'chambres' => 3,
            'sdb' => 2,
            'surface' => 120,
            'prix' => '12 500',
            'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3be0e?auto=format&fit=crop&w=900&q=80',
        ],
    ];
@endphp

@php
    $openAdmin = request('modal') === 'admin'
        || ($errors->any() && old('_form') === 'admin');

    $partnerModal = session('open_modal') === 'success' || session('inscription_success')
        ? 'success'
        : (request('modal') === 'login' || ($errors->any() && old('_form') === 'login')
            ? 'login'
            : (request('modal') === 'register' || ($errors->any() && old('_form') === 'register')
                ? 'register'
                : null));
@endphp

<div x-data="{
        menu: null,
        mobileOpen: false,
        mobileSection: null,
        adminOpen: @js($openAdmin),
        partnerModal: @js($partnerModal),
        toggleMenu(name) { this.menu = this.menu === name ? null : name; },
        toggleMobileSection(name) { this.mobileSection = this.mobileSection === name ? null : name; },
        openAdmin() { this.adminOpen = true; this.partnerModal = null; this.menu = null; this.mobileOpen = false; this.mobileSection = null; },
        closeAdmin() { this.adminOpen = false; },
        openPartnerLogin() { this.partnerModal = 'login'; this.adminOpen = false; this.menu = null; this.mobileOpen = false; this.mobileSection = null; },
        openPartnerRegister() { this.partnerModal = 'register'; this.adminOpen = false; this.menu = null; this.mobileOpen = false; this.mobileSection = null; },
        closePartner() { this.partnerModal = null; },
        anyModalOpen() { return this.adminOpen || !!this.partnerModal; }
     }"
     @keydown.escape.window="menu = null; mobileOpen = false; mobileSection = null; closeAdmin(); closePartner()"
     x-effect="document.documentElement.classList.toggle('admin-modal-open', adminOpen || !!partnerModal)"
     class="relative">

{{-- Header --}}
<header class="absolute inset-x-0 top-0 z-50">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 lg:px-8">
        <a href="{{ url('/') }}" class="relative z-10 shrink-0">
            <x-logo class="h-10 w-10" :show-wordmark="true" :inverse="true" />
        </a>

        <nav class="hidden items-center gap-1 text-[0.88rem] font-medium lg:flex">
            <a href="#accueil"
               class="group relative inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-gold-400 transition hover:bg-white/10">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Accueil
                <span class="absolute inset-x-3 -bottom-0.5 h-0.5 rounded-full bg-gold-400"></span>
            </a>

            <div class="relative" @click.outside="menu === 'agences' && (menu = null)">
                <button type="button" @click="toggleMenu('agences')"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                        :class="menu === 'agences' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    Nos Agences
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="menu === 'agences' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="menu === 'agences'" x-cloak x-transition
                     class="absolute left-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-2xl bg-white py-2 shadow-2xl shadow-navy-950/20 ring-1 ring-navy-100">
                    <div class="border-b border-navy-50 px-4 py-2.5">
                        <p class="text-[0.65rem] font-bold uppercase tracking-[0.16em] text-gold-600">Villes</p>
                    </div>
                    <div class="max-h-72 overflow-y-auto py-1">
                        @foreach ($villes as $ville)
                            <a href="{{ url('/?ville='.urlencode($ville)) }}#biens"
                               class="group flex items-center gap-3 px-3 py-2 text-sm text-navy-700 transition hover:bg-navy-50"
                               @click="menu = null">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-500 transition group-hover:bg-gold-100 group-hover:text-gold-700">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                </span>
                                <span class="font-medium group-hover:text-navy-900">{{ $ville }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="relative" @click.outside="menu === 'louer' && (menu = null)">
                <button type="button" @click="toggleMenu('louer')"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                        :class="menu === 'louer' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/></svg>
                    Biens À Louer
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="menu === 'louer' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="menu === 'louer'" x-cloak x-transition
                     class="absolute left-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-2xl bg-white py-2 shadow-2xl shadow-navy-950/20 ring-1 ring-navy-100">
                    <div class="border-b border-navy-50 px-4 py-2.5">
                        <p class="text-[0.65rem] font-bold uppercase tracking-[0.16em] text-gold-600">À louer</p>
                    </div>
                    @foreach ($typesBiens as $type => $icone)
                        <a href="{{ url('/?type='.urlencode($type).'&cat=louer') }}#biens"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm text-navy-700 transition hover:bg-navy-50"
                           @click="menu = null">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-500 transition group-hover:bg-gold-100 group-hover:text-gold-700">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            <span class="font-medium group-hover:text-navy-900">{{ $type }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="relative" @click.outside="menu === 'neufs' && (menu = null)">
                <button type="button" @click="toggleMenu('neufs')"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                        :class="menu === 'neufs' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                    Biens Neufs
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="menu === 'neufs' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="menu === 'neufs'" x-cloak x-transition
                     class="absolute left-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-2xl bg-white py-2 shadow-2xl shadow-navy-950/20 ring-1 ring-navy-100">
                    <div class="border-b border-navy-50 px-4 py-2.5">
                        <p class="text-[0.65rem] font-bold uppercase tracking-[0.16em] text-gold-600">Neufs</p>
                    </div>
                    @foreach ($typesBiens as $type => $icone)
                        <a href="{{ url('/?type='.urlencode($type).'&cat=neuf') }}#biens"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm text-navy-700 transition hover:bg-navy-50"
                           @click="menu = null">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-500 transition group-hover:bg-gold-100 group-hover:text-gold-700">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            <span class="font-medium group-hover:text-navy-900">{{ $type }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="relative" @click.outside="menu === 'services' && (menu = null)">
                <button type="button" @click="toggleMenu('services')"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                        :class="menu === 'services' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.785 16.5 21.75l-.394-.965a1.5 1.5 0 0 0-1.079-1.078l-.965-.394.965-.394a1.5 1.5 0 0 0 1.079-1.078l.394-.965.394.965a1.5 1.5 0 0 0 1.078 1.078l.965.394-.965.394a1.5 1.5 0 0 0-1.078 1.078Z"/></svg>
                    Nos Services
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="menu === 'services' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="menu === 'services'" x-cloak x-transition
                     class="absolute left-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-2xl bg-white py-2 shadow-2xl shadow-navy-950/20 ring-1 ring-navy-100">
                    <div class="border-b border-navy-50 px-4 py-2.5">
                        <p class="text-[0.65rem] font-bold uppercase tracking-[0.16em] text-gold-600">Services</p>
                    </div>
                    @foreach ($servicesMenu as $service => $icone)
                        <a href="{{ url('/?service='.urlencode($service)) }}#services"
                           class="group flex items-center gap-3 px-3 py-2.5 text-sm text-navy-700 transition hover:bg-navy-50"
                           @click="menu = null">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-500 transition group-hover:bg-gold-100 group-hover:text-gold-700">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            <span class="font-medium group-hover:text-navy-900">{{ $service }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <button type="button" @click="openPartnerLogin()"
                    class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                    :class="partnerModal && 'bg-white/10 text-gold-400'">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                Partenaire
            </button>

            <button type="button" @click="openAdmin()"
                    class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-white/85 transition hover:bg-white/10 hover:text-gold-300"
                    :class="adminOpen && 'bg-white/10 text-gold-400'">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                Admin
            </button>
        </nav>

        <div class="flex items-center gap-2">
            <button type="button" class="rounded-lg p-2 text-white transition hover:bg-white/10 lg:hidden" @click="mobileOpen = !mobileOpen; if (!mobileOpen) mobileSection = null" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition class="border-t border-white/10 bg-navy-950/95 px-5 py-4 backdrop-blur lg:hidden">
        <div class="space-y-1 text-sm text-white/90">
            <a href="#accueil" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gold-400" @click="mobileOpen=false; mobileSection=null">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Accueil
            </a>

            <div>
                <button type="button" @click="toggleMobileSection('agences')"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-white/10"
                        :class="mobileSection === 'agences' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    <span class="flex-1 font-medium">Nos Agences</span>
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="mobileSection === 'agences' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="mobileSection === 'agences'" x-cloak class="space-y-0.5 pb-2 pl-2">
                    @foreach ($villes as $ville)
                        <a href="{{ url('/?ville='.urlencode($ville)) }}#biens" class="flex items-center gap-3 rounded-lg px-3 py-1.5 text-white/75" @click="mobileOpen=false; mobileSection=null">
                            <span class="h-1.5 w-1.5 rounded-full bg-gold-500/70"></span>
                            {{ $ville }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="button" @click="toggleMobileSection('louer')"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-white/10"
                        :class="mobileSection === 'louer' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/></svg>
                    <span class="flex-1 font-medium">Biens À Louer</span>
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="mobileSection === 'louer' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="mobileSection === 'louer'" x-cloak class="space-y-0.5 pb-2 pl-2">
                    @foreach ($typesBiens as $type => $icone)
                        <a href="{{ url('/?type='.urlencode($type).'&cat=louer') }}#biens" class="flex items-center gap-3 rounded-lg px-3 py-1.5 text-white/75" @click="mobileOpen=false; mobileSection=null">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 text-gold-400">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            {{ $type }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="button" @click="toggleMobileSection('neufs')"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-white/10"
                        :class="mobileSection === 'neufs' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                    <span class="flex-1 font-medium">Biens Neufs</span>
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="mobileSection === 'neufs' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="mobileSection === 'neufs'" x-cloak class="space-y-0.5 pb-2 pl-2">
                    @foreach ($typesBiens as $type => $icone)
                        <a href="{{ url('/?type='.urlencode($type).'&cat=neuf') }}#biens" class="flex items-center gap-3 rounded-lg px-3 py-1.5 text-white/75" @click="mobileOpen=false; mobileSection=null">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 text-gold-400">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            {{ $type }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="button" @click="toggleMobileSection('services')"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left transition hover:bg-white/10"
                        :class="mobileSection === 'services' && 'bg-white/10 text-gold-400'">
                    <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                    <span class="flex-1 font-medium">Nos Services</span>
                    <svg class="h-3.5 w-3.5 opacity-70 transition duration-200" :class="mobileSection === 'services' && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div x-show="mobileSection === 'services'" x-cloak class="space-y-0.5 pb-2 pl-2">
                    @foreach ($servicesMenu as $service => $icone)
                        <a href="{{ url('/?service='.urlencode($service)) }}#services" class="flex items-center gap-3 rounded-lg px-3 py-1.5 text-white/75" @click="mobileOpen=false; mobileSection=null">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10 text-gold-400">
                                @include('partials.nav-type-icon', ['icone' => $icone])
                            </span>
                            {{ $service }}
                        </a>
                    @endforeach
                </div>
            </div>

            <button type="button" class="mt-2 flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left" @click="mobileOpen=false; mobileSection=null; openPartnerLogin()">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                Partenaire
            </button>
            <button type="button" class="mt-1 flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left" @click="mobileOpen=false; mobileSection=null; openAdmin()">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                Admin
            </button>
        </div>
    </div>
</header>

{{-- Hero --}}
<section id="accueil" class="relative">
    <div class="relative min-h-[100svh]">
        {{-- Fond seul (overflow) : ne doit pas couper la vidéo sur mobile --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2200&q=80"
                 alt=""
                 class="login-hero-img absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-950/85 via-navy-950/55 to-navy-950/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950/70 via-transparent to-navy-950/40"></div>
        </div>

        <div class="relative z-10 mx-auto flex min-h-[100svh] max-w-7xl flex-col justify-center px-5 pb-28 pt-28 sm:pb-36 lg:px-8 lg:pb-44">
            <div class="grid items-center gap-8 sm:gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)] lg:gap-12 xl:gap-16">
                @php
                    $hero = $habillement ?? \App\Models\Habillement::current();
                    $playback = $hero->videoPlayback();
                @endphp
                <div class="min-w-0">
                    <p class="login-anim-up font-sans text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Log<span class="text-gold-400">IN</span>
                    </p>

                    <h1 class="login-anim-up login-anim-up-delay-1 mt-5 max-w-xl font-sans text-3xl font-semibold leading-[1.15] tracking-tight text-white sm:text-4xl lg:text-[2.65rem] xl:text-5xl">
                        {!! $hero->titreWithEmphasis() !!}
                    </h1>

                    <p class="login-anim-up login-anim-up-delay-2 mt-5 max-w-md text-base leading-relaxed text-white/80 sm:text-lg">
                        {{ $hero->displayDescription() }}
                    </p>

                    <div class="login-anim-up login-anim-up-delay-3 mt-8">
                        <a href="#biens"
                           class="group inline-flex items-center gap-2.5 rounded-lg bg-navy-900 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-navy-800">
                            Découvrir nos biens
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Cadre vidéo publicitaire --}}
                <div class="login-anim-up login-anim-up-delay-2 w-full min-w-0">
                    <div class="login-promo-video overflow-hidden rounded-2xl ring-2 ring-gold-400/70">
                        @if ($playback && $playback['type'] === 'embed')
                            <iframe src="{{ $playback['src'] }}"
                                    title="Vidéo publicitaire LogIN"
                                    loading="eager"
                                    allowfullscreen
                                    playsinline
                                    webkitallowfullscreen
                                    mozallowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                    referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        @elseif ($playback)
                            <video controls playsinline webkit-playsinline preload="metadata" src="{{ $playback['src'] }}"></video>
                        @else
                            <div class="login-promo-placeholder flex flex-col items-center justify-center gap-4 bg-gradient-to-br from-navy-900/90 via-navy-950/80 to-navy-900/70 px-6 text-center">
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gold-400/15 ring-1 ring-gold-400/40">
                                    <svg class="h-8 w-8 text-gold-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8 5.14v13.72L19 12 8 5.14Z"/>
                                    </svg>
                                </span>
                                <p class="font-sans text-lg font-semibold tracking-tight text-white">Vidéo publicitaire</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-search-bar relative z-30 -mt-10 px-4 sm:-mt-12 sm:px-6 lg:px-8">
        <form action="#biens" method="get"
              class="mx-auto grid max-w-7xl gap-3 rounded-2xl bg-white p-3 shadow-2xl shadow-navy-950/20 ring-1 ring-navy-100 sm:grid-cols-2 lg:grid-cols-[1.1fr_1.2fr_1fr_1fr_auto] lg:items-end lg:gap-2 lg:p-4">
            <label class="block px-2 py-1">
                <span class="mb-1.5 block text-[0.7rem] font-semibold uppercase tracking-wider text-navy-400">Type de bien</span>
                <select name="type" class="w-full border-0 bg-transparent p-0 text-sm font-medium text-navy-900 outline-none">
                    @foreach ($typesBiens as $type => $icone)
                        <option>{{ $type }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block border-t border-navy-100 px-2 py-1 sm:border-t-0 sm:border-l">
                <span class="mb-1.5 block text-[0.7rem] font-semibold uppercase tracking-wider text-navy-400">Localisation</span>
                <select name="ville" class="w-full border-0 bg-transparent p-0 text-sm font-medium text-navy-900 outline-none">
                    <option value="">Ville ou quartier</option>
                    @foreach ($villes as $ville)
                        <option>{{ $ville }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block border-t border-navy-100 px-2 py-1 sm:border-l lg:border-t-0">
                <span class="mb-1.5 block text-[0.7rem] font-semibold uppercase tracking-wider text-navy-400">Budget max</span>
                <select name="budget" class="w-full border-0 bg-transparent p-0 text-sm font-medium text-navy-900 outline-none">
                    <option value="">Prix maximum</option>
                    <option>5 000 DH</option>
                    <option>8 000 DH</option>
                    <option>12 000 DH</option>
                    <option>20 000 DH</option>
                </select>
            </label>
            <label class="block border-t border-navy-100 px-2 py-1 sm:border-l lg:border-t-0">
                <span class="mb-1.5 block text-[0.7rem] font-semibold uppercase tracking-wider text-navy-400">Chambres</span>
                <select name="chambres" class="w-full border-0 bg-transparent p-0 text-sm font-medium text-navy-900 outline-none">
                    <option value="">Nombre de chambres</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4+</option>
                </select>
            </label>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-navy-900 px-5 py-3.5 text-sm font-semibold text-white hover:bg-navy-800 sm:col-span-2 lg:col-span-1">
                Rechercher
            </button>
        </form>
    </div>
</section>

<section id="services" class="bg-navy-50/80 pb-16 pt-16 sm:pt-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-600">Nos Services</p>
            <h2 class="mt-2 font-sans text-3xl font-bold tracking-tight text-navy-900">Un accompagnement complet</h2>
        </div>
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Biens vérifiés', 'Tous nos biens sont vérifiés.', 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
                ['Accompagnement', 'Un service client à votre écoute.', 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z'],
                ['Contrat sécurisé', 'Location en toute sérénité.', 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'],
                ['Meilleurs prix', 'Des prix compétitifs toute l\'année.', 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z'],
            ] as $item)
                <div class="flex gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-gold-600 shadow-sm ring-1 ring-navy-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item[2] }}"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-navy-900">{{ $item[0] }}</h3>
                        <p class="mt-1 text-sm text-navy-500">{{ $item[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="biens" class="bg-white py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-600">Sélection LogIN</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-navy-900 sm:text-4xl">Nos biens en vedette</h2>
            </div>
            <a href="#biens" class="group inline-flex items-center gap-2 text-sm font-semibold text-navy-700 hover:text-gold-600">
                Voir tous les biens
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($biens as $bien)
                <article class="group overflow-hidden rounded-2xl bg-white ring-1 ring-navy-100 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-navy-900/10">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $bien['image'] }}" alt="{{ $bien['titre'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <span class="absolute left-3 top-3 rounded-md bg-white/95 px-2.5 py-1 text-[0.7rem] font-bold uppercase tracking-wide text-navy-900">À louer</span>
                    </div>
                    <div class="p-4">
                        <h3 class="text-[0.95rem] font-bold text-navy-900">{{ $bien['titre'] }}</h3>
                        <p class="mt-1 text-xs text-navy-400">{{ $bien['lieu'] }}</p>
                        <div class="mt-3 flex items-center gap-3 text-xs text-navy-500">
                            @if ($bien['chambres'] > 0)<span>{{ $bien['chambres'] }} ch.</span>@endif
                            <span>{{ $bien['sdb'] }} sdb</span>
                            <span>{{ $bien['surface'] }} m²</span>
                        </div>
                        <p class="mt-4 text-base font-bold text-gold-600">{{ $bien['prix'] }} DH<span class="text-sm font-medium text-navy-400">/mois</span></p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

footer class="bg-navy-950 py-10 text-center text-xs text-white/40">
    © {{ date('Y') }} LogIN — Location immobilière. Tous droits réservés.
</footer>

{{-- Teleporte hors du hero anime (sinon fixed + transform = affichage casse) --}}
<template x-teleport="body">
    <div x-show="adminOpen"
         x-cloak
         x-effect="document.documentElement.classList.toggle('admin-modal-open', adminOpen || !!partnerModal)"
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/65 p-4"
         style="display: none;"
         @click.self="closeAdmin()">
        <div class="admin-login-panel w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl sm:p-7"
             role="dialog"
             aria-modal="true"
             aria-labelledby="admin-login-title"
             @click.stop>
            <h2 id="admin-login-title" class="text-center font-sans text-xl font-bold text-navy-900">Connexion Admin</h2>
            <p class="mt-1 text-center font-sans text-xs text-navy-400">Accès réservé aux utilisateurs du système</p>

            @if ($errors->any() && old('_form') === 'admin')
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 font-sans text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4" autocomplete="off">
                @csrf
                <input type="hidden" name="_form" value="admin">

                <div>
                    <label for="admin_statut" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Statut</label>
                    <select id="admin_statut" name="statut" required
                            class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                        <option value="">Sélectionner un statut</option>
                        <option value="superadmin" @selected(old('statut', 'superadmin') === 'superadmin')>Superadministrateur</option>
                        <option value="admin" @selected(old('statut') === 'admin')>Administrateur</option>
                    </select>
                </div>

                <div>
                    <label for="admin_login" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Login</label>
                    <input id="admin_login" name="login" type="text" required
                           value="{{ old('_form') === 'admin' ? old('login') : '' }}"
                           placeholder="Directeur Général"
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div>
                    <label for="admin_password" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Mot de passe</label>
                    <input id="admin_password" name="password" type="password" required
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 rounded-xl bg-navy-900 py-3 font-sans text-sm font-semibold text-white hover:bg-navy-800">
                        Se connecter
                    </button>
                    <button type="button" @click="closeAdmin()"
                            class="flex-1 rounded-xl border border-navy-200 py-3 font-sans text-sm font-semibold text-navy-700 hover:bg-navy-50">
                        Fermer
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

{{-- Panneaux Partenaire --}}
<template x-teleport="body">
    <div x-show="partnerModal"
         x-cloak
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/65 p-4"
         style="display: none;"
         @click.self="closePartner()">

        {{-- Connexion --}}
        <div x-show="partnerModal === 'login'" x-cloak
             class="admin-login-panel w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl sm:p-7"
             style="display: none;"
             role="dialog" aria-modal="true" @click.stop>
            <h2 class="text-center font-sans text-xl font-bold text-navy-900">Connexion partenaire</h2>

            @if ($errors->any() && old('_form') === 'login')
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 font-sans text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4" autocomplete="off">
                @csrf
                <input type="hidden" name="_form" value="login">

                <div>
                    <label for="partner_login" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Login</label>
                    <input id="partner_login" name="email" type="email" required
                           value="{{ old('_form') === 'login' ? old('email') : '' }}"
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div>
                    <label for="partner_password" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Mot de passe</label>
                    <input id="partner_password" name="password" type="password" required
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 rounded-xl bg-navy-900 py-3 font-sans text-sm font-semibold text-white hover:bg-navy-800">
                        Se connecter
                    </button>
                    <button type="button" @click="closePartner()" class="flex-1 rounded-xl border border-navy-200 py-3 font-sans text-sm font-semibold text-navy-700 hover:bg-navy-50">
                        Fermer
                    </button>
                </div>
            </form>

            <p class="mt-5 text-center font-sans text-sm text-navy-500">
                Pas encore inscrit ?
                <button type="button" @click="openPartnerRegister()" class="font-semibold text-gold-600 hover:text-gold-700">S'inscrire</button>
            </p>
        </div>

        {{-- Inscription --}}
        <div x-show="partnerModal === 'register'" x-cloak
             class="admin-login-panel w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl sm:p-7"
             style="display: none;"
             role="dialog" aria-modal="true" @click.stop>
            <h2 class="text-center font-sans text-xl font-bold text-navy-900">Inscription partenaire</h2>

            @if ($errors->any() && old('_form') === 'register')
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 font-sans text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('inscription.store') }}" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="_form" value="register">

                <div>
                    <label for="reg_nom" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Nom Complet</label>
                    <input id="reg_nom" name="nom_complet" type="text" required value="{{ old('nom_complet') }}"
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div>
                    <label for="reg_tel" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">N° de Téléphone</label>
                    <input id="reg_tel" name="telephone" type="tel" required value="{{ old('telephone') }}"
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div>
                    <label for="reg_email" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">E-mail</label>
                    <input id="reg_email" name="email" type="email" required value="{{ old('_form') === 'register' ? old('email') : '' }}"
                           class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                </div>

                <div>
                    <label for="reg_ville" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Ville</label>
                    <select id="reg_ville" name="ville" required
                            class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                        <option value="">Sélectionner une ville</option>
                        @foreach ($villes as $ville)
                            <option value="{{ $ville }}" @selected(old('ville') === $ville)>{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="reg_statut" class="mb-1.5 block font-sans text-sm font-semibold text-navy-800">Statut</label>
                    <select id="reg_statut" name="type_partenaire" required
                            class="w-full rounded-xl border border-navy-200 bg-white px-4 py-3 font-sans text-sm text-navy-900 outline-none focus:border-gold-400 focus:ring-4 focus:ring-gold-100">
                        <option value="">Sélectionner un statut</option>
                        <option value="agence" @selected(old('type_partenaire') === 'agence')>Agence</option>
                        <option value="freelance" @selected(old('type_partenaire') === 'freelance')>Freelance</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 rounded-xl bg-navy-900 py-3 font-sans text-sm font-semibold text-white hover:bg-navy-800">
                        Envoyer
                    </button>
                    <button type="button" @click="closePartner()" class="flex-1 rounded-xl border border-navy-200 py-3 font-sans text-sm font-semibold text-navy-700 hover:bg-navy-50">
                        Annuler
                    </button>
                </div>
            </form>
        </div>

        {{-- Succes --}}
        <div x-show="partnerModal === 'success'" x-cloak
             class="admin-login-panel w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl sm:p-7"
             style="display: none;"
             role="dialog" aria-modal="true" @click.stop>
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            <h2 class="mt-5 text-center font-sans text-xl font-bold text-navy-900">Inscription enregistrée</h2>
            <p class="mt-3 text-center font-sans text-sm leading-relaxed text-navy-600">
                Votre inscription a bien été enregistrée. Votre compte est actuellement en attente d'approbation par l'administrateur.
                Vous serez informé par e-mail dès son activation.
            </p>
            <button type="button" @click="closePartner()"
                    class="mt-6 w-full rounded-xl bg-navy-900 py-3 font-sans text-sm font-semibold text-white hover:bg-navy-800">
                Fermer
            </button>
        </div>
    </div>
</template>

</div>
@endsection
