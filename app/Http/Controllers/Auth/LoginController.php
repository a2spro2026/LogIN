<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PartnerRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }

            return redirect()->route('home');
        }

        return redirect()->route('home', ['modal' => 'admin']);
    }

    public function attempt(Request $request)
    {
        $isAdminForm = $request->input('_form') === 'admin';
        $backToModal = route('home', ['modal' => $isAdminForm ? 'admin' : 'login']);

        if ($isAdminForm) {
            return $this->attemptAdmin($request, $backToModal);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Veuillez saisir votre login (e-mail).',
            'email.email' => 'Le login doit être une adresse e-mail valide.',
            'password.required' => 'Veuillez saisir votre mot de passe.',
        ]);

        $pending = PartnerRegistration::where('email', $credentials['email'])
            ->where('status', 'pending')
            ->exists();

        if ($pending && ! User::where('email', $credentials['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Votre compte est en attente d\'approbation par l\'administrateur.',
            ])->redirectTo($backToModal);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Identifiants incorrects. Vérifiez votre login et votre mot de passe.',
            ])->redirectTo($backToModal);
        }

        $request->session()->regenerate();

        if (! Auth::user()->isAdmin()) {
            return redirect()
                ->route('home')
                ->with('status', 'Connexion partenaire réussie. L’espace partenaire sera bientôt disponible.');
        }

        return redirect()->intended(route('dashboard'));
    }

    protected function attemptAdmin(Request $request, string $backToModal)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'statut' => ['required', 'in:admin,superadmin'],
        ], [
            'login.required' => 'Veuillez saisir votre login.',
            'password.required' => 'Veuillez saisir votre mot de passe.',
            'statut.required' => 'Veuillez sélectionner un statut.',
            'statut.in' => 'Statut invalide.',
        ]);

        $login = trim($data['login']);

        $user = User::query()
            ->where(function ($query) use ($login) {
                $query->where('name', $login)->orWhere('email', $login);
            })
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => 'Identifiants incorrects. Vérifiez votre login et votre mot de passe.',
            ])->redirectTo($backToModal);
        }

        if (! $user->isAdmin() || $user->role !== $data['statut']) {
            throw ValidationException::withMessages([
                'statut' => 'Le statut sélectionné ne correspond pas à ce compte.',
            ])->redirectTo($backToModal);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Vous avez été déconnecté.');
    }
}
