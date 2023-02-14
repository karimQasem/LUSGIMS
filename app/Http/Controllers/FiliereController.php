<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Filiere;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreFiliereRequest;
use App\Http\Requests\UpdateFiliereRequest;
use App\Interfaces\FiliereRepositoryInterface;

class FiliereController extends Controller
{
    private FiliereRepositoryInterface $FiliereRepository;

    public function __construct(FiliereRepositoryInterface $FiliereRepository)
    {
        $this->FiliereRepository = $FiliereRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Filieres/Index', [
            'filieres'=> fn () => $this->FiliereRepository->getAllFilieres(),
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
     * @param  \App\Http\Requests\StoreFiliereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFiliereRequest $request)
    {
        $this->FiliereRepository->createFiliere($request->validated());
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function show(Filiere $filiere)
    {
        $this->FiliereRepository->getFiliereById($filiere->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Filiere $filiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFiliereRequest  $request
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFiliereRequest $request, Filiere $filiere)
    {
        $this->FiliereRepository->updateFiliere($filiere->id, $request->validated());
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filiere $filiere)
    {
        $this->FiliereRepository->deleteFiliere($filiere->id);
        return Redirect::back();
    }
}
