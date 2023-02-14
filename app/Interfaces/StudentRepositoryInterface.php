<?php

namespace App\Interfaces;

interface StudentRepositoryInterface
{
    public function getAllStudents();
    public function getStudentById($studentId);
    public function deleteStudent($studentId);
    public function createStudent(array $data);
    public function updateStudent($studentId, array $data);
}
