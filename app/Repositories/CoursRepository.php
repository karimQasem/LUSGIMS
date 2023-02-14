<?php

namespace App\Repositories;

use App\Interfaces\CoursRepositoryInterface;
use App\Models\Cours;

class CoursRepository implements CoursRepositoryInterface
{
    public function getAllCourses()
    {
        return Cours::with('teacher')->get();
    }

    public function getCoursById($coursId)
    {
        return Cours::findOrFail($coursId);
    }

    public function deleteCours($coursId)
    {
        Cours::destroy($coursId);
    }

    public function createCours(array $data)
    {
        return Cours::create($data);
    }

    public function updateCours($coursId, array $data)
    {
        return Cours::whereId($coursId)->update($data);
    }
}
