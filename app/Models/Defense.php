<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Defense extends Model
{
    protected $fillable = [
        'etudiant_id',
        'date_heure',
        'salle',
        'sujet',
        'type',
        'statut',
        'notes',
        'note_finale',
        'mention',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
        'note_finale' => 'float',
    ];

    // Relationships
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function juryMembres(): HasMany
    {
        return $this->hasMany(JuryMembre::class);
    }

    // Helper methods
    public function getDateFormateeAttribute(): string
    {
        return $this->date_heure->format('d/m/Y H:i');
    }

    public function getJuryAttribute()
    {
        return $this->juryMembres()->with('professeur')->get();
    }

    public function getPresidentJuryAttribute()
    {
        return $this->juryMembres()
            ->where('role', 'president')
            ->with('professeur')
            ->first();
    }

    public function getRapporteursAttribute()
    {
        return $this->juryMembres()
            ->where('role', 'rapporteur')
            ->with('professeur')
            ->get();
    }

    public function getEncadrantAttribute()
    {
        return $this->juryMembres()
            ->where('role', 'encadrant')
            ->with('professeur')
            ->first();
    }
}
