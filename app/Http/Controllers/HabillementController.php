<?php

namespace App\Http\Controllers;

use App\Models\Habillement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HabillementController extends Controller
{
    public function edit()
    {
        return view('configuration.habillement', [
            'active' => 'configuration-habillement',
            'habillement' => Habillement::current(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'titre' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime,video/x-msvideo', 'max:102400'],
            'video_url' => ['nullable', 'string', 'max:1000'],
        ]);

        $habillement = Habillement::current();
        $habillement->titre = $data['titre'] ?? null;
        $habillement->description = $data['description'] ?? null;

        $url = isset($data['video_url']) ? trim($data['video_url']) : null;
        $habillement->video_url = $url !== '' ? $url : null;

        if ($request->hasFile('video')) {
            if ($habillement->video_path) {
                Storage::disk('public')->delete($habillement->video_path);
            }
            $habillement->video_path = $request->file('video')->store('videos', 'public');
            // Fichier importé prioritaire : on garde l’URL si renseignée, mais le fichier s’affiche en premier
        }

        if ($request->boolean('clear_video')) {
            if ($habillement->video_path) {
                Storage::disk('public')->delete($habillement->video_path);
            }
            $habillement->video_path = null;
            $habillement->video_url = null;
        }

        $habillement->save();

        return redirect()
            ->route('configuration.habillement')
            ->with('status', 'Habillement enregistré. La vidéo est visible sur la page d’accueil.');
    }
}
