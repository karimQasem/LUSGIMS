<?php

namespace App\Repositories;

use App\Interfaces\FiliereRepositoryInterface;
use App\Models\Filiere;

class FiliereRepository implements FiliereRepositoryInterface
{
    public function getAllFilieres()
    {
        return Filiere::with('courses')->get();
    }

    public function getFiliereById($filiereId)
    {
        return Filiere::findOrFail($filiereId);
    }

    public function deleteFiliere($filiereId)
    {
        Filiere::destroy($filiereId);
    }

    public function createFiliere(array $data)
    {
        return Filiere::create($data);
    }

    public function updateFiliere($filiereId, array $data)
    {
        return Filiere::whereId($filiereId)->update($data);
    }

    public function addCourseToFiliere($filiereId, $courseId)
    {
        $filiere = $this->getFiliereById($filiereId);
        $filiere->courses()->syncWithoutDetaching([$courseId]);
        return $filiere;
    }
}
