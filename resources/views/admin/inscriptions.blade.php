@extends('layouts.dashboard')

@section('title', 'Inscriptions partenaires — LogIN')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-sans text-2xl font-bold text-navy-900">Inscriptions partenaires</h1>
        <p class="mt-1 text-sm text-navy-500">Validez ou refusez les demandes d’inscription en attente.</p>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-navy-100">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-navy-50 text-xs uppercase tracking-wide text-navy-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Nom</th>
                        <th class="px-5 py-3 font-semibold">Téléphone</th>
                        <th class="px-5 py-3 font-semibold">Ville</th>
                        <th class="px-5 py-3 font-semibold">Type</th>
                        <th class="px-5 py-3 font-semibold">E-mail</th>
                        <th class="px-5 py-3 font-semibold">Statut</th>
                        <th class="px-5 py-3 font-semibold">Date</th>
                        <th class="px-5 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-100">
                    @forelse ($inscriptions as $inscription)
                        <tr class="hover:bg-navy-50/50">
                            <td class="px-5 py-4 font-medium text-navy-900">{{ $inscription->nom_complet }}</td>
                            <td class="px-5 py-4 text-navy-600">{{ $inscription->telephone }}</td>
                            <td class="px-5 py-4 text-navy-600">{{ $inscription->ville }}</td>
                            <td class="px-5 py-4 text-navy-600">
                                {{ $inscription->type_partenaire === 'agence' ? 'Agence' : ($inscription->type_partenaire === 'freelance' ? 'Freelance' : '—') }}
                            </td>
                            <td class="px-5 py-4 text-navy-600">{{ $inscription->email }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $badge = match ($inscription->status) {
                                        'approved' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                        'rejected' => 'bg-red-50 text-red-700 ring-red-200',
                                        default => 'bg-amber-50 text-amber-700 ring-amber-200',
                                    };
                                    $label = match ($inscription->status) {
                                        'approved' => 'Approuvée',
                                        'rejected' => 'Refusée',
                                        default => 'En attente',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $badge }}">{{ $label }}</span>
                            </td>
                            <td class="px-5 py-4 text-navy-500">{{ $inscription->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4">
                                @if ($inscription->status === 'pending')
                                    <div class="flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('admin.inscriptions.approve', $inscription) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-500">Approuver</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.inscriptions.reject', $inscription) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">Refuser</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-navy-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-navy-400">Aucune demande d’inscription pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($inscriptions->hasPages())
            <div class="border-t border-navy-100 px-5 py-4">
                {{ $inscriptions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
