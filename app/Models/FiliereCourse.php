<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiliereCourse extends Pivot
{
    use HasFactory;
    protected $table = 'filiere_courses';
    protected $fillable = [
        'filiere_id',
        'cours_id'
    ];
}
