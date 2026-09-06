<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Document extends Model
{
    // Types de documents
    const TYPE_RAPPORT = 'rapport';
    const TYPE_PRESENTATION = 'presentation';
    const TYPE_FICHE_EVALUATION = 'fiche_evaluation';
    const TYPE_AUTRE = 'autre';

    // Statuts possibles
    const STATUT_SOUMIS = 'soumis';
    const STATUT_VALIDE = 'valide';
    const STATUT_REFUSE = 'refuse';
    const STATUT_EN_ATTENTE = 'en_attente';

    protected $table = 'documents';
    protected $primaryKey = 'id_document';
    public $timestamps = true;

    protected $fillable = [
        'etudiant_id',
        'type',
        'titre',
        'chemin_fichier',
        'nom_fichier_original',
        'extension',
        'taille_mo',
        'statut',
        'commentaire',
        'est_version_corrigee',
        'date_soumission'
    ];

    protected $casts = [
        'est_version_corrigee' => 'boolean',
        'taille_mo' => 'float',
        'date_soumission' => 'datetime',
    ];

    /**
     * Relation avec l'étudiant propriétaire du document
     */
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id_etudiant');
    }

    /**
     * Vérifie si le document est un rapport
     */
    public function estRapport(): bool
    {
        return $this->type === self::TYPE_RAPPORT;
    }

    /**
     * Vérifie si le document est une présentation
     */
    public function estPresentation(): bool
    {
        return $this->type === self::TYPE_PRESENTATION;
    }

    /**
     * Vérifie si le document est une fiche d'évaluation
     */
    public function estFicheEvaluation(): bool
    {
        return $this->type === self::TYPE_FICHE_EVALUATION;
    }

    /**
     * Vérifie si le document est validé
     */
    public function estValide(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }

    /**
     * Vérifie si le document est refusé
     */
    public function estRefuse(): bool
    {
        return $this->statut === self::STATUT_REFUSE;
    }

    /**
     * Formate la taille du fichier de manière lisible
     */
    public function getTailleFormateeAttribute(): string
    {
        if ($this->taille_mo < 1) {
            return round($this->taille_mo * 1024, 2) . ' Ko';
        }
        return round($this->taille_mo, 2) . ' Mo';
    }

    /**
     * Récupère l'icône correspondant au type de document
     */
    public function getIconeAttribute(): string
    {
        switch ($this->extension) {
            case 'pdf':
                return 'fa-file-pdf';
            case 'doc':
            case 'docx':
                return 'fa-file-word';
            case 'xls':
            case 'xlsx':
                return 'fa-file-excel';
            case 'ppt':
            case 'pptx':
                return 'fa-file-powerpoint';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'fa-file-image';
            case 'zip':
            case 'rar':
            case '7z':
                return 'fa-file-archive';
            default:
                return 'fa-file';
        }
    }

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->date_soumission)) {
                $document->date_soumission = now();
            }
        });
    }

    /**
     * Relation avec les remarques sur le document
     */
    public function remarques(): HasMany
    {
        return $this->hasMany(Remarque::class, 'document_id', 'id_document');
    }

    // Helper methods
    public function getTypeTraduitAttribute(): string
    {
        return [
            'rapport' => 'Rapport',
            'fichier_stage' => 'Fichier de stage',
            'autre' => 'Autre document',
        ][$this->type] ?? $this->type;
    }

    public function getStatutClasseAttribute(): string
    {
        return [
            'soumis' => 'info',
            'en_attente' => 'warning',
            'approuve' => 'success',
            'rejete' => 'danger',
        ][$this->statut] ?? 'secondary';
    }
}
