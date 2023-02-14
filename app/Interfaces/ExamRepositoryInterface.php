<?php

namespace App\Interfaces;

interface ExamRepositoryInterface
{
    public function getAllExams();
    public function getExamById($examId);
    public function deleteExam($examId);
    public function createExam(array $data);
    public function updateExam($examId, array $data);
}
