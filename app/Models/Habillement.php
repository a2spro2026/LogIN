<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Habillement extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'video_path',
        'video_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function hasVideo(): bool
    {
        return filled($this->video_path) || filled($this->video_url);
    }

    /**
     * @return array{type: string, src: string}|null
     */
    public function videoPlayback(): ?array
    {
        if (filled($this->video_path) && Storage::disk('public')->exists($this->video_path)) {
            return [
                'type' => 'file',
                'src' => Storage::disk('public')->url($this->video_path),
            ];
        }

        if (! filled($this->video_url)) {
            return null;
        }

        $url = trim($this->video_url);

        if ($embed = $this->toEmbedUrl($url)) {
            return [
                'type' => 'embed',
                'src' => $embed,
            ];
        }

        return [
            'type' => 'url',
            'src' => $url,
        ];
    }

    protected function toEmbedUrl(string $url): ?string
    {
        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/'.$m[1].'?playsinline=1&rel=0&modestbranding=1';
        }

        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1].'?playsinline=1';
        }

        return null;
    }

    public function displayTitre(): string
    {
        return filled($this->titre)
            ? $this->titre
            : 'La meilleure façon de louer votre futur chez-vous';
    }

    public function displayDescription(): string
    {
        return filled($this->description)
            ? $this->description
            : 'Des appartements, villas et bureaux sélectionnés pour votre confort et votre tranquillité.';
    }

    public function titreWithEmphasis(): string
    {
        $titre = e($this->displayTitre());

        // Met en or le dernier mot si possible (ex. "chez-vous")
        if (Str::contains($titre, 'chez-vous')) {
            return str_replace(
                'chez-vous',
                '<em class="font-serif font-medium italic text-gold-400">chez-vous</em>',
                $titre
            );
        }

        return $titre;
    }
}
