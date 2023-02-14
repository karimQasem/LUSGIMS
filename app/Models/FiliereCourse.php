<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiliereCourse extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'filiere_id',
        'cours_id'
    ];
}
