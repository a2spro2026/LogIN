@extends('layouts.dashboard')

@section('title', "Règlement — LogIN")

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
                <span class="text-slate-600 font-medium">Règlement</span>
            </nav>
            <h1 class="mt-2 font-serif text-3xl font-bold text-slate-900">Règlement</h1>
        </div>
        <a href="#form-reg" onclick="setTimeout(function(){document.getElementById('fournisseur_id') && document.getElementById('fournisseur_id').focus();},80)"
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
    <div id="form-reg" class="rounded-2xl bg-white border border-slate-100 shadow-sm scroll-mt-24">
        <form method="POST" action="{{ $isEdit ? route('reglement.update', $editing) : route('reglement.store') }}" class="p-6">
            @csrf
            @if ($isEdit) @method('PUT') @endif
            <div class="flex flex-wrap items-end gap-x-3 gap-y-3">

                <div class="w-[150px]">
                    <label for="date" class="block text-xs font-medium text-slate-600 mb-1">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $isEdit ? $editing->date?->format('Y-m-d') : now()->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[190px]">
                    <label for="fournisseur_id" class="block text-xs font-medium text-slate-600 mb-1">Nom Fournisseur</label>
                    <select id="fournisseur_id" name="fournisseur_id" required
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                        <option value="">— Choisir —</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" @selected((int) old('fournisseur_id', $isEdit ? $editing->fournisseur_id : null) === $fournisseur->id)>{{ $fournisseur->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-[200px]">
                    <label for="bon_achat_id" class="block text-xs font-medium text-slate-600 mb-1">Réf Bon</label>
                    <select id="bon_achat_id" name="bon_achat_id" required
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                        <option value="">— Choisir —</option>
                        @foreach ($bons as $bon)
                            <option value="{{ $bon->id }}"
                                    data-montant="{{ number_format((float) $bon->sous_total, 2, '.', '') }}"
                                    data-fournisseur="{{ $bon->fournisseur_id }}"
                                    @selected((int) old('bon_achat_id', $isEdit ? $editing->bon_achat_id : null) === $bon->id)>
                                {{ $bon->ref_bn }} — {{ $bon->designation }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-[130px]">
                    <label for="montant_bon" class="block text-xs font-medium text-slate-600 mb-1">Montant Bon</label>
                    <input type="text" id="montant_bon" value="{{ $isEdit ? number_format((float) $editing->montant_bon, 2, '.', ' ') : '0.00' }}" readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-1.5 text-[13px] font-semibold text-slate-700 outline-none">
                </div>

                <div class="w-[120px]">
                    <label for="ref_reglement" class="block text-xs font-medium text-slate-600 mb-1">Réf Règl</label>
                    <input type="text" id="ref_reglement" name="ref_reglement" value="{{ old('ref_reglement', $isEdit ? $editing->ref_reglement : $prochaineRef) }}" placeholder="REG-0001"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[130px]">
                    <label for="type_reglement" class="block text-xs font-medium text-slate-600 mb-1">Type Règ</label>
                    <select id="type_reglement" name="type_reglement"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                        <option value="">—</option>
                        @foreach ($typesReglement as $type)
                            <option value="{{ $type }}" @selected(old('type_reglement', $isEdit ? $editing->type_reglement : null) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-[120px]">
                    <label for="numero" class="block text-xs font-medium text-slate-600 mb-1">N° Règ</label>
                    <input type="text" id="numero" name="numero" value="{{ old('numero', $isEdit ? $editing->numero : '') }}" placeholder="N°"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[140px]">
                    <label for="banque" class="block text-xs font-medium text-slate-600 mb-1">Bnq Règ</label>
                    <input type="text" id="banque" name="banque" value="{{ old('banque', $isEdit ? $editing->banque : '') }}" placeholder="Banque"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[160px]">
                    <label for="nom_tire" class="block text-xs font-medium text-slate-600 mb-1">Nom Tiré</label>
                    <input type="text" id="nom_tire" name="nom_tire" value="{{ old('nom_tire', $isEdit ? $editing->nom_tire : '') }}" placeholder="Nom du tiré"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[120px]">
                    <label for="montant_reglement" class="block text-xs font-medium text-slate-600 mb-1">Mnt Règ</label>
                    <input type="number" step="0.01" min="0" id="montant_reglement" name="montant_reglement" value="{{ old('montant_reglement', $isEdit ? number_format((float) $editing->montant_reglement, 2, '.', '') : '0.00') }}" placeholder="0.00"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>

                <div class="w-[150px]">
                    <label for="date_decaissement" class="block text-xs font-medium text-slate-600 mb-1">Date Décaiss</label>
                    <input type="date" id="date_decaissement" name="date_decaissement" value="{{ old('date_decaissement', $isEdit ? $editing->date_decaissement?->format('Y-m-d') : '') }}"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-900 focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition shadow-lg shadow-brand-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9"/></svg>
                    {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
                @if ($isEdit)
                    <a href="{{ route('reglement.fiche') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
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

    {{-- Tableau d'affichage --}}
    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-900">Affichage des règlements</h2>
            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">{{ $reglements->count() }} règlement(s)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3 font-medium">Date</th>
                        <th class="px-4 py-3 font-medium">Fournisseur</th>
                        <th class="px-4 py-3 font-medium">Réf Bon</th>
                        <th class="px-4 py-3 font-medium">Type</th>
                        <th class="px-4 py-3 font-medium">N°</th>
                        <th class="px-4 py-3 font-medium">Bnq</th>
                        <th class="px-4 py-3 font-medium text-right">Echéance</th>
                        <th class="px-4 py-3 font-medium text-right">Mnt Bon</th>
                        <th class="px-4 py-3 font-medium text-right">Mnt Règ</th>
                        <th class="px-4 py-3 font-medium text-right">Solde</th>
                        <th class="px-4 py-3 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($reglements as $r)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $r->date?->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-slate-900">{{ $r->fournisseur->nom ?? '—' }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-900 whitespace-nowrap">{{ $r->bonAchat->ref_bn ?? '—' }}</td>
                            <td class="px-4 py-4">
                                @if ($r->type_reglement)
                                    <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-600">{{ $r->type_reglement }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $r->numero ?: '—' }}</td>
                            <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $r->banque ?: '—' }}</td>
                            <td class="px-4 py-4 text-right text-slate-600 whitespace-nowrap">{{ !is_null($r->bonAchat?->echeance) ? $r->bonAchat->echeance.' j' : '—' }}</td>
                            <td class="px-4 py-4 text-right text-slate-600 whitespace-nowrap">{{ number_format((float) $r->montant_bon, 2, '.', ' ') }}</td>
                            <td class="px-4 py-4 text-right text-slate-600 whitespace-nowrap">{{ number_format((float) $r->montant_reglement, 2, '.', ' ') }}</td>
                            <td class="px-4 py-4 text-right font-semibold whitespace-nowrap {{ $r->solde > 0 ? 'text-red-600' : 'text-emerald-600' }}">{{ number_format($r->solde, 2, '.', ' ') }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('reglement.edit', $r) }}" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition" title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                                    </a>
                                    <a href="{{ route('reglement.print', $r) }}" target="_blank" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Imprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('reglement.destroy', $r) }}" onsubmit="return confirm('Supprimer ce règlement ?');" class="inline">
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
                            <td colspan="11" class="px-6 py-12 text-center text-sm text-slate-400">Aucun règlement enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    (function () {
        var bon = document.getElementById('bon_achat_id');
        var montant = document.getElementById('montant_bon');
        var fournisseur = document.getElementById('fournisseur_id');
        var type = document.getElementById('type_reglement');
        var numero = document.getElementById('numero');
        var banque = document.getElementById('banque');
        var nomTire = document.getElementById('nom_tire');
        var mntRegl = document.getElementById('montant_reglement');
        if (!bon || !montant || !fournisseur) { return; }

        function getBonAmount() {
            var opt = bon.options[bon.selectedIndex];
            return (opt && opt.value) ? (parseFloat(opt.getAttribute('data-montant')) || 0) : 0;
        }

        function setMontant() {
            var m = getBonAmount();
            montant.value = m.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Affiche uniquement les bons non soldés du fournisseur choisi.
        function filterBons(resetSelection) {
            var fId = fournisseur.value;
            for (var i = 0; i < bon.options.length; i++) {
                var opt = bon.options[i];
                if (!opt.value) { continue; } // placeholder
                var match = fId && opt.getAttribute('data-fournisseur') === fId;
                opt.hidden = !match;
                opt.disabled = !match;
                if (!match && opt.selected && resetSelection) { bon.value = ''; }
            }
            if (resetSelection) { setMontant(); }
        }

        // Grise (verrouille) un champ tout en gardant sa valeur soumise.
        function grise(el, off) {
            if (!el) { return; }
            el.style.background = off ? '#e2e8f0' : '';
            el.style.opacity = off ? '0.6' : '';
            el.style.pointerEvents = off ? 'none' : '';
        }

        // Espèces : pas de N°, Banque ni Nom Tiré.
        function updateTypeFields() {
            var esp = type && (type.value === 'Espèces');
            [numero, banque, nomTire].forEach(function (el) {
                if (!el) { return; }
                el.disabled = esp;
                if (esp) { el.value = ''; }
                grise(el, esp);
            });
        }

        // Si le montant réglé couvre entièrement le bon, on verrouille la Réf Bon.
        function updateBonLock() {
            var bonAmt = getBonAmount();
            var reg = parseFloat(mntRegl ? mntRegl.value : '') || 0;
            var solde = bonAmt > 0 && Math.abs(reg - bonAmt) < 0.005;
            grise(bon, solde);
        }

        fournisseur.addEventListener('change', function () { filterBons(true); updateBonLock(); });
        bon.addEventListener('change', function () { setMontant(); updateBonLock(); });
        if (type) { type.addEventListener('change', updateTypeFields); }
        if (mntRegl) { mntRegl.addEventListener('input', updateBonLock); }

        // État initial (mode édition ou ancienne saisie).
        filterBons(false);
        updateTypeFields();
        updateBonLock();
    })();
</script>
@endsection
