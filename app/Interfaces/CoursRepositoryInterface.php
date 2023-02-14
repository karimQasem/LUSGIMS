<?php

namespace App\Interfaces;

interface CoursRepositoryInterface
{
    public function getAllCourses();
    public function getCoursById($coursId);
    public function deleteCours($coursId);
    public function createCours(array $data);
    public function updateCours($coursId, array $data);
}
