@extends('layouts.dashboard')

@section('title', "Fiche Fournisseur — LogIN")

@section('content')
<div class="space-y-6">

    {{-- En-tête --}}
    <div class="flex items-end justify-between gap-3">
        <div>
            <nav class="text-sm text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-brand-600">Tableau de bord</a>
                <span class="mx-2">/</span>
                <span class="text-slate-500">Fournisseur</span>
                <span class="mx-2">/</span>
                <span class="text-slate-600 font-medium">Fiche Fournisseur</span>
            </nav>
            <h1 class="mt-2 font-serif text-3xl font-bold text-slate-900">Fiche Fournisseur</h1>
        </div>
        <a href="#form-fiche" onclick="setTimeout(function(){document.getElementById('nom') && document.getElementById('nom').focus();},80)"
           class="group relative inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shrink-0 transition duration-300 hover:-translate-y-0.5">
            <span class="absolute -inset-0.5 rounded-xl bg-gradient-to-r from-brand-500 via-amber-400 to-brand-500 opacity-60 blur-md transition duration-300 group-hover:opacity-100"></span>
            <span class="absolute inset-0 rounded-xl bg-gradient-to-r from-brand-500 to-amber-500 shadow-lg shadow-brand-500/40"></span>
            <span class="relative flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Ajouter
            </span>
        </a>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Barres de saisie --}}
    @php $isEdit = !empty($editing); @endphp
    <div id="form-fiche" class="rounded-2xl bg-white border border-slate-100 shadow-sm scroll-mt-24">
        <form method="POST" action="{{ $isEdit ? route('fournisseur.update', $editing) : route('fournisseur.store') }}" class="p-6">
            @csrf
            @if ($isEdit) @method('PUT') @endif
            <div class="flex flex-wrap items-end gap-x-3 gap-y-3">

                <div class="w-[150px]">
                    <label for="date_creation" class="block text-xs font-medium text-slate-600 mb-1">Date Création</label>
                    <input type="date" id="date_creation" name="date_creation" value="{{ old('date_creation', $isEdit ? $editing->date_creation?->format('Y-m-d') : now()->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[120px]">
                    <label for="code" class="block text-xs font-medium text-slate-600 mb-1">ID</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $isEdit ? $editing->code : $prochainCode) }}" placeholder="FRN-0001"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="nom" class="block text-xs font-medium text-slate-600 mb-1">Nom Fournisseur</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $isEdit ? $editing->nom : '') }}" placeholder="Ex. Grossiste Méditerranée" required
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[140px]">
                    <label for="ville" class="block text-xs font-medium text-slate-600 mb-1">Ville</label>
                    <input type="text" id="ville" name="ville" value="{{ old('ville', $isEdit ? $editing->ville : '') }}" placeholder="Ex. Marseille"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[160px]">
                    <label for="contact" class="block text-xs font-medium text-slate-600 mb-1">Contact</label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $isEdit ? $editing->contact : '') }}" placeholder="Tél. / e-mail"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[140px]">
                    <label for="type_reglement" class="block text-xs font-medium text-slate-600 mb-1">Type Règl</label>
                    <select id="type_reglement" name="type_reglement"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                        <option value="">—</option>
                        @foreach ($typesReglement as $type)
                            <option value="{{ $type }}" @selected(old('type_reglement', $isEdit ? $editing->type_reglement : null) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-[110px]">
                    <label for="echeance" class="block text-xs font-medium text-slate-600 mb-1">Echéance (j)</label>
                    <input type="number" id="echeance" name="echeance" value="{{ old('echeance', $isEdit ? $editing->echeance : '') }}" min="0" max="3650" placeholder="30"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[120px]">
                    <label for="solde_initial" class="block text-xs font-medium text-slate-600 mb-1">Solde Initial</label>
                    <input type="number" step="0.01" id="solde_initial" name="solde_initial" value="{{ old('solde_initial', $isEdit ? number_format((float) $editing->solde_initial, 2, '.', '') : '0.00') }}" placeholder="0.00"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition shadow-lg shadow-brand-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9"/></svg>
                    {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
                @if ($isEdit)
                    <a href="{{ route('fournisseur.fiche') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Annuler
                    </a>
                @else
                    <button type="reset" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Réinitialiser
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- Tableau de consultation --}}
    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-900">Consultation des fournisseurs</h2>
            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">{{ $fournisseurs->count() }} fournisseur(s)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-slate-400 border-b border-slate-100">
                        <th class="px-6 py-3 font-medium">Date Création</th>
                        <th class="px-6 py-3 font-medium">ID</th>
                        <th class="px-6 py-3 font-medium">Nom Fournisseur</th>
                        <th class="px-6 py-3 font-medium">Ville</th>
                        <th class="px-6 py-3 font-medium">Contact</th>
                        <th class="px-6 py-3 font-medium">Type Règl</th>
                        <th class="px-6 py-3 font-medium">Echéance</th>
                        <th class="px-6 py-3 font-medium text-right">Solde Initial</th>
                        <th class="px-6 py-3 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($fournisseurs as $f)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">{{ $f->date_creation?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900 whitespace-nowrap">{{ $f->code }}</td>
                            <td class="px-6 py-4 text-slate-900">{{ $f->nom }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $f->ville ?: '—' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $f->contact ?: '—' }}</td>
                            <td class="px-6 py-4">
                                @if ($f->type_reglement)
                                    <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-600">{{ $f->type_reglement }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">{{ !is_null($f->echeance) ? $f->echeance.' j' : '—' }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-900 whitespace-nowrap">{{ number_format((float) $f->solde_initial, 2, '.', ' ') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('fournisseur.edit', $f) }}" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition" title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                                    </a>
                                    <a href="{{ route('fournisseur.print', $f) }}" target="_blank" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Imprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('fournisseur.destroy', $f) }}" onsubmit="return confirm('Supprimer ce fournisseur ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-sm text-slate-400">Aucun fournisseur enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
