<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;

class professeurs extends Model
{
    protected $table = 'professeurs';
    
    protected $fillable = [
        'nom_prof',
        'prenom_prof',
        'role_prof',
        'email_prof',
        'password_prof',
    ];

    protected $hidden = [
        'password_prof',
    ];

    /**
     * The soutenances that belong to the professeur as a jury member.
     */
    public function soutenances(): BelongsToMany
    {
        return $this->belongsToMany(soutenances::class, 'jury_membres', 'professeur_id', 'soutenance_id')
            ->withTimestamps();
    }

    /**
     * Set the professor's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordProfAttribute($value)
    {
        $this->attributes['password_prof'] = Hash::make($value);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->prenom_prof} {$this->nom_prof}";
    }
}
