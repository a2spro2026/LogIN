<?php

use App\Http\Controllers\AdminInscriptionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BonAchatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HabillementController;
use App\Http\Controllers\PartnerRegistrationController;
use App\Http\Controllers\ReglementController;
use App\Models\Habillement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'habillement' => Habillement::current(),
    ]);
})->name('home');

Route::post('/inscription', [PartnerRegistrationController::class, 'store'])->name('inscription.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/inscriptions', [AdminInscriptionController::class, 'index'])->name('admin.inscriptions');
    Route::post('/dashboard/inscriptions/{inscription}/approve', [AdminInscriptionController::class, 'approve'])->name('admin.inscriptions.approve');
    Route::post('/dashboard/inscriptions/{inscription}/reject', [AdminInscriptionController::class, 'reject'])->name('admin.inscriptions.reject');

    Route::get('/dashboard/fournisseur-fiche', [FournisseurController::class, 'index'])->name('fournisseur.fiche');
    Route::post('/dashboard/fournisseur-fiche', [FournisseurController::class, 'store'])->name('fournisseur.store');
    Route::get('/dashboard/fournisseur-fiche/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseur.edit');
    Route::put('/dashboard/fournisseur-fiche/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseur.update');
    Route::get('/dashboard/fournisseur-fiche/{fournisseur}/print', [FournisseurController::class, 'print'])->name('fournisseur.print');
    Route::delete('/dashboard/fournisseur-fiche/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseur.destroy');

    Route::get('/dashboard/fournisseur-bon-achat', [BonAchatController::class, 'index'])->name('bon-achat.fiche');
    Route::post('/dashboard/fournisseur-bon-achat', [BonAchatController::class, 'store'])->name('bon-achat.store');
    Route::get('/dashboard/fournisseur-bon-achat/{bonAchat}/edit', [BonAchatController::class, 'edit'])->name('bon-achat.edit');
    Route::put('/dashboard/fournisseur-bon-achat/{bonAchat}', [BonAchatController::class, 'update'])->name('bon-achat.update');
    Route::get('/dashboard/fournisseur-bon-achat/{bonAchat}/print', [BonAchatController::class, 'print'])->name('bon-achat.print');
    Route::delete('/dashboard/fournisseur-bon-achat/{bonAchat}', [BonAchatController::class, 'destroy'])->name('bon-achat.destroy');

    Route::get('/dashboard/fournisseur-reglement', [ReglementController::class, 'index'])->name('reglement.fiche');
    Route::post('/dashboard/fournisseur-reglement', [ReglementController::class, 'store'])->name('reglement.store');
    Route::get('/dashboard/fournisseur-reglement/{reglement}/edit', [ReglementController::class, 'edit'])->name('reglement.edit');
    Route::put('/dashboard/fournisseur-reglement/{reglement}', [ReglementController::class, 'update'])->name('reglement.update');
    Route::get('/dashboard/fournisseur-reglement/{reglement}/print', [ReglementController::class, 'print'])->name('reglement.print');
    Route::delete('/dashboard/fournisseur-reglement/{reglement}', [ReglementController::class, 'destroy'])->name('reglement.destroy');

    Route::get('/dashboard/configuration-habillement', [HabillementController::class, 'edit'])->name('configuration.habillement');
    Route::put('/dashboard/configuration-habillement', [HabillementController::class, 'update'])->name('configuration.habillement.update');

    Route::get('/dashboard/{section}', [DashboardController::class, 'section'])->name('dashboard.section');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
