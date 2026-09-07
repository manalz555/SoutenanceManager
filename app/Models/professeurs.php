<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class professeurs extends Model
{
    public const ROLES = [
        'encadrant'   => 'Encadrant',
        'rapporteur'  => 'Rapporteur',
        'examinateur' => 'Examinateur',
        'president'   => 'Président',
    ];

    protected $table = 'professeurs';

    protected $fillable = ['nom_prof', 'prenom_prof', 'role_prof', 'email_prof', 'password_prof'];

    protected $hidden = ['password_prof'];

    protected $casts = ['password_prof' => 'hashed'];

    /** Soutenances où le professeur siège dans le jury. */
    public function soutenances(): BelongsToMany
    {
        return $this->belongsToMany(soutenances::class, 'jury_membres', 'professeur_id', 'soutenance_id')
            ->withPivot(['role', 'note', 'commentaire'])
            ->withTimestamps();
    }

    public function etudiantsEncadres(): HasMany
    {
        return $this->hasMany(etudiants::class, 'encadrant_id');
    }

    public function etudiantsRapportes(): HasMany
    {
        return $this->hasMany(etudiants::class, 'rapporteur_id');
    }

    public function remarques(): HasMany
    {
        return $this->hasMany(Remarque::class, 'professeur_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->prenom_prof} {$this->nom_prof}";
    }

    public function getRoleLibelleAttribute(): string
    {
        return self::ROLES[$this->role_prof] ?? ucfirst($this->role_prof);
    }
}
