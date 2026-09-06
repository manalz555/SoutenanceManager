<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class soutenances extends Model
{
    protected $table = 'soutenances';
    
    protected $fillable = [
        'etudiant_id',
        'Date_Sout',
        'Salle_Sout',
        'Note_finale',
    ];

    protected $dates = [
        'Date_Sout',
    ];

    /**
     * Get the student that owns the soutenance.
     */
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(etudiants::class, 'etudiant_id');
    }

    /**
     * The professeurs that belong to the soutenance as jury members.
     */
    public function juryMembers(): BelongsToMany
    {
        return $this->belongsToMany(professeurs::class, 'jury_membres', 'soutenance_id', 'professeur_id')
            ->withTimestamps();
    }

    /**
     * Get the formatted date attribute.
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return $this->Date_Sout->format('d/m/Y H:i');
    }

    /**
     * Get the status of the defense.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->Note_finale > 0) {
            return 'Terminée';
        }
        
        if ($this->Date_Sout->isPast()) {
            return 'En attente de notation';
        }
        
        return 'Planifiée';
    }
}
