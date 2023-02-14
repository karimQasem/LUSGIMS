<?php

namespace App\Interfaces;

interface TeacherRepositoryInterface
{
    public function getAllTeachers();
    public function getTeacherById($teacherId);
    public function deleteTeacher($teacherId);
    public function createTeacher(array $data);
    public function updateTeacher($teacherId, array $data);
}
