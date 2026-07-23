<?php

namespace App\Http\Controllers;

use App\Models\PartnerRegistration;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PartnerRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $back = route('home', ['modal' => 'register']);

        try {
            $data = $request->validate([
                'nom_complet' => ['required', 'string', 'max:255'],
                'telephone' => ['required', 'string', 'max:30'],
                'ville' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:255', 'unique:partner_registrations,email', 'unique:users,email'],
                'type_partenaire' => ['required', 'in:agence,freelance'],
            ], [
                'nom_complet.required' => 'Le nom complet est obligatoire.',
                'telephone.required' => 'Le numéro de téléphone est obligatoire.',
                'ville.required' => 'La ville est obligatoire.',
                'email.required' => "L'adresse e-mail est obligatoire.",
                'email.email' => "L'adresse e-mail n'est pas valide.",
                'email.unique' => 'Cette adresse e-mail est déjà utilisée ou en attente.',
                'type_partenaire.required' => 'Veuillez sélectionner un statut.',
                'type_partenaire.in' => 'Statut invalide.',
            ]);
        } catch (ValidationException $e) {
            throw $e->redirectTo($back);
        }

        PartnerRegistration::create([
            ...$data,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('home')
            ->with('inscription_success', true)
            ->with('open_modal', 'success');
    }
}
