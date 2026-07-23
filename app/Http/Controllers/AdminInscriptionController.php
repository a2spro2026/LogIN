<?php

namespace App\Http\Controllers;

use App\Models\PartnerRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminInscriptionController extends Controller
{
    public function index()
    {
        return view('admin.inscriptions', [
            'inscriptions' => PartnerRegistration::latest()->paginate(15),
            'active' => 'inscriptions',
        ]);
    }

    public function approve(PartnerRegistration $inscription)
    {
        if ($inscription->status !== 'pending') {
            return back()->with('status', 'Cette demande a déjà été traitée.');
        }

        $tempPassword = Str::password(10);

        User::updateOrCreate(
            ['email' => $inscription->email],
            [
                'name' => $inscription->nom_complet,
                'telephone' => $inscription->telephone,
                'ville' => $inscription->ville,
                'role' => 'partner',
                'password' => Hash::make($tempPassword),
            ]
        );

        $inscription->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('status', "Inscription approuvée. Compte créé pour {$inscription->email}. Mot de passe temporaire : {$tempPassword}");
    }

    public function reject(PartnerRegistration $inscription)
    {
        if ($inscription->status !== 'pending') {
            return back()->with('status', 'Cette demande a déjà été traitée.');
        }

        $inscription->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('status', 'Demande d\'inscription refusée.');
    }
}
