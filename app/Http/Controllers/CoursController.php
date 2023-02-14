<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cours;
use App\Http\Requests\StoreCoursRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateCoursRequest;
use App\Interfaces\CoursRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;

class CoursController extends Controller
{
    private CoursRepositoryInterface $coursRepository;
    private TeacherRepositoryInterface $teacherRepository;

    public function __construct(CoursRepositoryInterface $coursRepository, TeacherRepositoryInterface $teacherRepository)
    {
        $this->coursRepository = $coursRepository;
        $this->teacherRepository=$teacherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Courses/Index', [
            'courses'=> fn () => $this->coursRepository->getAllCourses(),
            'teachers'=> fn () => $this->teacherRepository->getAllTeachers()
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
     * @param  \App\Http\Requests\StoreCoursRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursRequest $request)
    {
        $this->coursRepository->createCours($request->validated());
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function show(Cours $cour)
    {
        $this->coursRepository->getCoursById($cour->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function edit(Cours $cour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursRequest  $request
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursRequest $request, Cours $cour)
    {
        $this->coursRepository->updateCours($cour->id, $request->validated());
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cours $cour)
    {
        $this->coursRepository->deleteCours($cour->id);
        return Redirect::back();
    }
}
