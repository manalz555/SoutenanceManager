<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    public const TYPES = [
        'dossier_stage' => 'Dossier de stage',
        'rapport'       => 'Rapport final',
    ];

    public const STATUTS = [
        'soumis' => 'En attente',
        'valide' => 'Validé',
        'rejete' => 'Rejeté',
    ];

    protected $table = 'documents';

    protected $fillable = [
        'etudiant_id', 'type', 'titre', 'chemin_fichier', 'nom_fichier_original',
        'extension', 'taille_mo', 'statut', 'commentaire', 'est_version_corrigee', 'date_soumission',
    ];

    protected $casts = [
        'est_version_corrigee' => 'boolean',
        'taille_mo' => 'float',
        'date_soumission' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Document $document) {
            $document->date_soumission ??= now();
        });
    }

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(etudiants::class, 'etudiant_id');
    }

    public function remarques(): HasMany
    {
        return $this->hasMany(Remarque::class, 'document_id');
    }

    public function getTypeLibelleAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getStatutLibelleAttribute(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function getStatutBadgeAttribute(): string
    {
        return match ($this->statut) {
            'valide' => 'badge-success',
            'rejete' => 'badge-danger',
            default  => 'badge-warning',
        };
    }

    public function getTailleFormateeAttribute(): string
    {
        return $this->taille_mo < 1
            ? round($this->taille_mo * 1024) . ' Ko'
            : round($this->taille_mo, 2) . ' Mo';
    }
}
