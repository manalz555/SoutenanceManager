<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Remarque extends Model
{
    // Statuts possibles
    const STATUT_OUVERT = 'ouvert';
    const STATUT_EN_COURS = 'en_cours';
    const STATUT_RESOLU = 'resolu';
    const STATUT_FERME = 'ferme';

    // Niveaux de priorité
    const PRIORITE_FAIBLE = 'faible';
    const PRIORITE_MOYENNE = 'moyenne';
    const PRIORITE_HAUTE = 'haute';
    const PRIORITE_CRITIQUE = 'critique';

    protected $table = 'remarques';
    protected $primaryKey = 'id_remarque';
    public $timestamps = true;

    protected $fillable = [
        'document_id',
        'professeur_id',
        'contenu',
        'statut',
        'date_remarque',
        'date_resolution',
        'commentaire_resolution',
        'priorite',
        'titre',
        'type_remarque',
        'est_urgent'
    ];

    protected $casts = [
        'date_remarque' => 'datetime',
        'date_resolution' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'est_urgent' => 'boolean',
    ];

    protected $appends = [
        'statut_libelle',
        'priorite_libelle',
        'est_resolue',
        'jours_ecoules'
    ];

    /**
     * Relation avec le document concerné par la remarque
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id_document');
    }

    /**
     * Relation avec le professeur qui a émis la remarque
     */
    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class, 'professeur_id', 'id_professeur')
            ->withDefault([
                'nom' => 'Professeur inconnu',
                'prenom' => ''
            ]);
    }

    /**
     * Scope pour les remarques non résolues
     */
    public function scopeNonResolues($query)
    {
        return $query->where('statut', '!=', self::STATUT_RESOLU)
                    ->where('statut', '!=', self::STATUT_FERME);
    }

    /**
     * Scope pour les remarques urgentes
     */
    public function scopeUrgentes($query)
    {
        return $query->where('est_urgent', true);
    }

    /**
     * Vérifie si la remarque est résolue
     */
    public function estResolue(): bool
    {
        return in_array($this->statut, [self::STATUT_RESOLU, self::STATUT_FERME]);
    }

    /**
     * Vérifie si la remarque est en cours de traitement
     */
    public function estEnCours(): bool
    {
        return $this->statut === self::STATUT_EN_COURS;
    }

    /**
     * Marque la remarque comme résolue
     */
    public function marquerCommeResolue(string $commentaire = null): void
    {
        $this->update([
            'statut' => self::STATUT_RESOLU,
            'date_resolution' => now(),
            'commentaire_resolution' => $commentaire
        ]);
    }

    /**
     * Marque la remarque comme en cours de traitement
     */
    public function marquerEnCours(): void
    {
        $this->update(['statut' => self::STATUT_EN_COURS]);
    }

    /**
     * Marque la remarque comme urgente
     */
    public function marquerUrgente(bool $urgent = true): void
    {
        $this->update(['est_urgent' => $urgent]);
    }

    /**
     * Accesseur pour le libellé du statut
     */
    public function getStatutLibelleAttribute(): string
    {
        return [
            self::STATUT_OUVERT => 'Ouvert',
            self::STATUT_EN_COURS => 'En cours',
            self::STATUT_RESOLU => 'Résolu',
            self::STATUT_FERME => 'Fermé',
        ][$this->statut] ?? 'Inconnu';
    }

    /**
     * Accesseur pour le libellé de la priorité
     */
    public function getPrioriteLibelleAttribute(): string
    {
        return [
            self::PRIORITE_FAIBLE => 'Faible',
            self::PRIORITE_MOYENNE => 'Moyenne',
            self::PRIORITE_HAUTE => 'Haute',
            self::PRIORITE_CRITIQUE => 'Critique',
        ][$this->priorite] ?? 'Non définie';
    }

    /**
     * Accesseur pour la classe CSS du statut
     */
    public function getStatutClasseAttribute(): string
    {
        return [
            self::STATUT_OUVERT => 'badge badge-warning',
            self::STATUT_EN_COURS => 'badge badge-info',
            self::STATUT_RESOLU => 'badge badge-success',
            self::STATUT_FERME => 'badge badge-secondary',
        ][$this->statut] ?? 'badge badge-light';
    }

    /**
     * Accesseur pour la classe CSS de la priorité
     */
    public function getPrioriteClasseAttribute(): string
    {
        return [
            self::PRIORITE_FAIBLE => 'badge badge-light',
            self::PRIORITE_MOYENNE => 'badge badge-info',
            self::PRIORITE_HAUTE => 'badge badge-warning',
            self::PRIORITE_CRITIQUE => 'badge badge-danger',
        ][$this->priorite] ?? 'badge badge-secondary';
    }

    /**
     * Accesseur pour le nombre de jours écoulés depuis la création
     */
    public function getJoursEcoulesAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Vérifie si la remarque est ancienne (plus de 7 jours)
     */
    public function getEstAncienneAttribute(): bool
    {
        return $this->created_at->diffInDays(now()) > 7;
    }

    /**
     * Méthode pour obtenir les options de statut
     */
    public static function getStatuts(): array
    {
        return [
            self::STATUT_OUVERT => 'Ouvert',
            self::STATUT_EN_COURS => 'En cours',
            self::STATUT_RESOLU => 'Résolu',
            self::STATUT_FERME => 'Fermé',
        ];
    }

    /**
     * Méthode pour obtenir les options de priorité
     */
    public static function getPriorites(): array
    {
        return [
            self::PRIORITE_FAIBLE => 'Faible',
            self::PRIORITE_MOYENNE => 'Moyenne',
            self::PRIORITE_HAUTE => 'Haute',
            self::PRIORITE_CRITIQUE => 'Critique',
        ];
    }

    /**
     * Événements du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Définir la date de création avant l'insertion
        static::creating(function ($remarque) {
            if (empty($remarque->date_remarque)) {
                $remarque->date_remarque = now();
            }
            if (empty($remarque->statut)) {
                $remarque->statut = self::STATUT_OUVERT;
            }
            if (empty($remarque->priorite)) {
                $remarque->priorite = self::PRIORITE_MOYENNE;
            }
        });
    }
}
