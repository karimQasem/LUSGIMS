<?php

namespace App\Repositories;

use App\Interfaces\TeacherRepositoryInterface;
use App\Models\Teacher;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function getAllTeachers()
    {
        return Teacher::with('user')->get();
    }

    public function getTeacherById($teacherId)
    {
        return Teacher::findOrFail($teacherId);
    }

    public function deleteTeacher($teacherId)
    {
        Teacher::destroy($teacherId);
    }

    public function createTeacher(array $data)
    {
        return Teacher::create($data);
    }

    public function updateTeacher($teacherId, array $data)
    {
        return Teacher::whereId($teacherId)->update($data);
    }
}
