<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FreelanceController extends Controller
{
    public function index()
    {
        // Fetch all verified freelancers with their associated user data
        $freelances = Freelance::query()
            ->where('is_verified', true)
            ->with(['user'])
            ->get();

        // ensuite je devrai ajouter 'autres chose pour pouvoir ajouter les filtres et les recherches & pagination
        // boost apparaisent en premier
        // filtres sur les skills, les professions, les experiences, les certifications
        // tri par défaut ?
        // recherche ? dynamique ?


        return Inertia::render( 'Freelance/Index',[
            'freelances' => $freelances
        ]);
    }


    public function show($slug)
    {
        // Fetch the freelance profile with the given slug, including related data
        $freelance = Freelance::where('slug', $slug)
            ->with(['user', 'skills', 'professions', 'experiences', 'certifications', 'freelanceMedias'])
            ->firstOrFail();

        return Inertia::render('Freelance/Show', [
            'freelance' => $freelance
        ]);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
