<?php

namespace App\Models;

use App\Models\Cours;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'number_hours'
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'filiere_courses', 'filiere_id', 'cours_id');
    }
}
