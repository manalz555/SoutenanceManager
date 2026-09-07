<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remarque extends Model
{
    protected $table = 'remarques';

    protected $fillable = [
        'etudiant_id', 'professeur_id', 'document_id', 'sujet', 'contenu', 'statut', 'date_resolution',
    ];

    protected $casts = ['date_resolution' => 'datetime'];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(etudiants::class, 'etudiant_id');
    }

    public function professeur(): BelongsTo
    {
        return $this->belongsTo(professeurs::class, 'professeur_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function estTraitee(): bool
    {
        return $this->statut === 'traitee';
    }

    public function marquerTraitee(): void
    {
        $this->update(['statut' => 'traitee', 'date_resolution' => now()]);
    }
}
