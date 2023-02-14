<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAllStudents()
    {
        return Student::with('user')->get();
    }

    public function getStudentById($studentId)
    {
        return Student::findOrFail($studentId);
    }

    public function deleteStudent($studentId)
    {
        Student::destroy($studentId);
    }

    public function createStudent(array $data)
    {
        return Student::create($data);
    }

    public function updateStudent($studentId, array $data)
    {
        return Student::whereId($studentId)->update($data);
    }
}
