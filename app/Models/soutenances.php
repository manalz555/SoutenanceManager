<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class soutenances extends Model
{
    protected $table = 'soutenances';

    protected $fillable = ['etudiant_id', 'Date_Sout', 'Salle_Sout', 'Note_finale'];

    protected $casts = [
        'Date_Sout'   => 'datetime',
        'Note_finale' => 'float',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(etudiants::class, 'etudiant_id');
    }

    public function juryMembers(): BelongsToMany
    {
        return $this->belongsToMany(professeurs::class, 'jury_membres', 'soutenance_id', 'professeur_id')
            ->withPivot(['role', 'note', 'commentaire'])
            ->withTimestamps();
    }

    public function getStatusAttribute(): string
    {
        if ($this->Note_finale !== null) {
            return 'Terminée';
        }

        return $this->Date_Sout->isPast() ? 'En attente de notation' : 'Planifiée';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Terminée' => 'badge-info',
            'En attente de notation' => 'badge-warning',
            default => 'badge-success',
        };
    }

    /** Recalcule la note finale (moyenne des notes du jury) dès que tout le jury a noté. */
    public function recalculerNoteFinale(): void
    {
        $membres = $this->juryMembers()->get();
        $notes = $membres->pluck('pivot.note')->filter(fn ($n) => $n !== null);

        if ($membres->count() > 0 && $notes->count() === $membres->count()) {
            $this->Note_finale = round($notes->avg(), 2);
            $this->save();
        }
    }
}
