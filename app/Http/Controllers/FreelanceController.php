<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        $isEditable = auth()->check() && auth()->user()->id === $freelance->user_id;

        if (!$isEditable && !$freelance->is_verified)
        {
            abort(404, 'Freelance profile not found');
        }

        return Inertia::render('Freelance/Show', [
            'freelance' => $freelance,
            'isEditable' => $isEditable
        ]);
    }

    /*
     * Upload image into public storage and update the path in the database for freelance profile
     * */
    public function updateImage(Request $request)
    {
         $request->validate([
            'cover' => 'nullable|image',
            'avatar' => 'nullable|image'
        ]);

        $freelance = auth()->user()->freelance;

        $success = '';

        if ($request->hasFile('cover')) {
            if ($freelance->cover_picture) {
                Storage::disk('public')->delete($freelance->cover_picture);
            }
            $coverPath = $request->file('cover')->storeAs('freelances', $freelance->slug . '-cover', 'public');
            $freelance->update(['cover_picture' => Storage::url($coverPath)]);
            $success = 'Votre bannière a été mise à jour';
        }

       if ($request->hasFile('avatar')) {
            if ($freelance->profile_picture) {
                Storage::disk('public')->delete($freelance->profile_picture);
            }
            $avatarPath = $request->file('avatar')->storeAs('freelances', $freelance->slug . '-avatar', 'public');
            $freelance->update(['profile_picture' => Storage::url($avatarPath)]);
            $success = 'Votre photo de profil a été mise à jour';
       }

       return back()->with('success', $success);
    }
}
