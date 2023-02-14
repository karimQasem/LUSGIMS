<?php

namespace App\Interfaces;

interface FiliereRepositoryInterface
{
    public function getAllFilieres();
    public function getFiliereById($filiereId);
    public function deleteFiliere($filiereId);
    public function createFiliere(array $data);
    public function updateFiliere($filiereId, array $data);
    public function addCourseToFiliere($filiereId, $courseId);
}
