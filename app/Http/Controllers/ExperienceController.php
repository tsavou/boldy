<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;

class ExperienceController extends Controller
{
    public function store(ExperienceRequest $request)
    {
        $freelance = auth()->user()->freelance;

        $freelance->experiences()->create($request->validated());

        return redirect()->back()->with('success', 'Experience ajoutée avec succès');
    }

    public function update(ExperienceRequest $request, Experience $experience)
    {

        $experience->update($request->validated());

        return redirect()->back()->with('success', 'Experience mise à jour avec succès');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->back()->with('success', 'Experience supprimée avec succès');
    }
}
