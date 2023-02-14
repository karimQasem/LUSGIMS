<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Inertia\Inertia;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Interfaces\CoursRepositoryInterface;
use Illuminate\Support\Facades\Redirect;
use App\Interfaces\ExamRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;

class ExamController extends Controller
{
    private ExamRepositoryInterface $ExamRepository;
    private CoursRepositoryInterface $CoursRepository;
    private TeacherRepositoryInterface $TeacherRepository;
    public function __construct(ExamRepositoryInterface $ExamRepository, CoursRepositoryInterface $CoursRepository, TeacherRepositoryInterface $TeacherRepository)
    {
        $this->ExamRepository = $ExamRepository;
        $this->CoursRepository = $CoursRepository;
        $this->TeacherRepository = $TeacherRepository;
    }
    /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index()
    {
        return Inertia::render('Exams/Index', [
            'exams'=> fn () => $this->ExamRepository->getAllExams(),
            'courses'=> fn () => $this->CoursRepository->getAllCourses(),
            'teachers'=> fn () => $this->TeacherRepository->getAllTeachers()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamRequest $request)
    {
        $this->ExamRepository->createExam($request->validated());
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $this->ExamRepository->getExamById($exam->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExamRequest  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->ExamRepository->updateExam($exam->id, $request->validated());
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $this->ExamRepository->deleteExam($exam->id);
        return Redirect::back();
    }
}
