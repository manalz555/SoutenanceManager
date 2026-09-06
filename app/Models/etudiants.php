<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class etudiants extends Model
{
    protected $table = 'etudiants';
    protected $primaryKey = 'id_etudiant';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'email',
        'mot_de_passe',
        'id_encadrant',
        'id_rapporteur'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * Get the documents for the student.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'id_etudiant', 'id_etudiant');
    }

    /**
     * Get the remarks for the student.
     */
    public function remarques(): HasMany
    {
        return $this->hasMany(Remarque::class, 'id_etudiant', 'id_etudiant');
    }

    /**
     * Get the student's defense.
     */
    public function soutenance(): HasOne
    {
        return $this->hasOne(Soutenance::class, 'id_etudiant', 'id_etudiant');
    }

    /**
     * Get the student's advisor (encadrant).
     */
    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Professeur::class, 'id_encadrant', 'id_professeur');
    }

    /**
     * Get the student's reporter (rapporteur).
     */
    public function rapporteur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class, 'id_rapporteur', 'id_professeur');
    }

    /**
     * Check if the student has a scheduled defense.
     *
     * @return bool
     */
    public function hasSoutenancePlanifiee(): bool
    {
        return $this->soutenance && $this->soutenance->date_soutenance > now();
    }

    /**
     * Get all submitted documents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDocumentsSoumis()
    {
        return $this->documents()->where('statut', 'soumis')->get();
    }

    /**
     * Get the latest submitted report.
     *
     * @return \App\Models\Document|null
     */
    public function getDernierRapport()
    {
        return $this->documents()
            ->where('type', 'rapport')
            ->orderBy('date_soumission', 'desc')
            ->first();
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Check if the student has submitted all required documents.
     *
     * @return bool
     */
    public function hasSubmittedAllDocuments(): bool
    {
        $requiredDocs = ['rapport', 'presentation', 'fiche_evaluation'];
        $submittedDocs = $this->documents()->where('statut', 'soumis')
            ->pluck('type')
            ->toArray();

        return count(array_intersect($requiredDocs, $submittedDocs)) === count($requiredDocs);
    }

    /**
     * Hash the password before saving.
     *
     * @param string $value
     * @return void
     */
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::make($value);
    }
}
