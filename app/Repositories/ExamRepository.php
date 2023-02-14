<?php

namespace App\Repositories;

use App\Interfaces\ExamRepositoryInterface;
use App\Models\Exam;

class ExamRepository implements ExamRepositoryInterface
{
    public function getAllExams()
    {
        return Exam::with(['teacher','cours'])->get();
    }

    public function getExamById($examId)
    {
        return Exam::findOrFail($examId);
    }

    public function deleteExam($examId)
    {
        Exam::destroy($examId);
    }

    public function createExam(array $data)
    {
        return Exam::create($data);
    }

    public function updateExam($examId, array $data)
    {
        return Exam::whereId($examId)->update($data);
    }
}
