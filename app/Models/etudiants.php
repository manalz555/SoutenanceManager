<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class etudiants extends Model
{
    protected $table = 'etudiants';

    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'email', 'password',
        'matricule', 'filiere', 'annee_universitaire', 'telephone',
        'encadrant_id', 'rapporteur_id',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'date_naissance' => 'date',
        'password' => 'hashed',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'etudiant_id')->latest('date_soumission');
    }

    public function remarques(): HasMany
    {
        return $this->hasMany(Remarque::class, 'etudiant_id')->latest();
    }

    public function soutenance(): HasOne
    {
        return $this->hasOne(soutenances::class, 'etudiant_id');
    }

    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(professeurs::class, 'encadrant_id');
    }

    public function rapporteur(): BelongsTo
    {
        return $this->belongsTo(professeurs::class, 'rapporteur_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /** Dernier rapport déposé (toutes versions confondues). */
    public function dernierRapport(): ?Document
    {
        return $this->documents()->where('type', 'rapport')->first();
    }
}
