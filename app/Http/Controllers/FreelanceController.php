<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelanceFilterRequest;
use App\Models\Freelance;
use App\Models\Profession;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FreelanceController extends Controller
{
    public function index(FreelanceFilterRequest $request)
    {
        // Récupérer les freelances avec leurs professions, compétences et expériences
        // et filtrer en fonction des critères de recherche
        $query = Freelance::verified()
            ->with(['professions', 'skills', 'experiences'])

            // disponibilité
            ->when($request->has('available'), fn($q) => $q->where('is_available', $request->input('available')))

            // professions
            ->when($request->filled('job'), fn($q) => $q->whereHas('professions',
                fn($subQ) => $subQ->where('name', 'like', $request->input('job'))))

            // skills
            ->when($request->filled('skill'),
                fn($q) => $q->whereHas('skills', fn($subQ) => $subQ->where('name', 'like', $request->input('skill'))))

            // ville
            ->when($request->filled('city'), fn($q) => $q->where('location', 'like', '%'.$request->input('city').'%'))

            //recherche libre parmis les noms, prénoms, compétences et professions
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($subQ) use ($search) {
                    $subQ->whereHas('user', fn($userQ) => $userQ->where('name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%"))
                        ->orWhereHas('skills', fn($skillQ) => $skillQ->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('professions', fn($jobQ) => $jobQ->where('name', 'like', "%{$search}%"));
                });
            })

            // tarifs
            ->when($request->filled('min_price'),
                fn($q) => $q->where('price_per_day', '>=', $request->input('min_price')))
            ->when($request->filled('max_price'),
                fn($q) => $q->where('price_per_day', '<=', $request->input('max_price')))

            //filtres sur l'experience
            // En utilisant "having" plutôt que "where" car "experience_in_years" et "experience_level" sont des colonnes virtuelles non existantes dans la DB
            // Elles sont calculées dans le scope ExperienceDataScope

            ->when($request->filled('level'), function ($q) use ($request) {
                $levels = collect($request->input('level'))
                    ->map(fn($level) => strtolower($level))->toArray();
                $placeholders = implode(',', array_fill(0, count($levels), '?'));
                $q->havingRaw("LOWER(experience_level) IN ($placeholders)", $levels);
            })
            ->when($request->filled('min_exp'),
                fn($q) => $q->having('experience_in_years', '>=', $request->input('min_exp'))
            )
            ->when($request->filled('max_exp'),
                fn($q) => $q->having('experience_in_years', '<=', $request->input('max_exp'))
            );


        // tri dynamique
        if ($request->filled('sort')) {
            switch ($request->get('sort')) {
                case 'price_asc':
                    $query->orderBy('price_per_day', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_day', 'desc');
                    break;
                case 'experience_desc':
                    $query->orderBy('experience_in_years', 'desc');
                    break;
                case 'experience_asc':
                    $query->orderBy('experience_in_years', 'asc');
                    break;
                case 'recent':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        // Trier par freelances boostés en premier
        $query->withExists([
            'boosts as is_boosted' => function ($q) {
                $q->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            }
        ])->orderByDesc('is_boosted');

        // Pagination des résultats en gardant les paramètres de requête
        $freelances = $query->paginate(12)->withQueryString();

        // Récupérer les villes distinctes pour le filtre
        $cities = Freelance::whereNotNull('location')
            ->pluck('location')
            ->map(fn($city) => strtolower(trim($city)))
            ->unique()
            ->map(fn($city) => ucfirst($city))
            ->values();

        return Inertia::render('Freelance/Index', [
            'freelances'    => $freelances,
            'professions'   => Profession::all(),
            'skills'        => Skill::all(),
            'cities'        => $cities,
            'activeFilters' => $request->all(),
        ]);
    }

    /**
     * Show the freelance profile with the given slug.
     * If the profile is not editable (i.e., not owned by the authenticated user) and not verified, return a 404 error.
     *
     * @return \Inertia\Response
     */
    public function show($slug)
    {
        // Fetch the freelance profile with the given slug, including related data
        $freelance = Freelance::where('slug', $slug)
            ->with([
                'user',
                'skills',
                'professions',
                'experiences'    => fn($query) => $query->orderByDesc('start_date'),
                'certifications' => fn($query) => $query->orderByDesc('year'),
                'links',
                'freelanceMedias'
            ])
            ->first();

        if (!$freelance) {
            abort(404, 'Ce profil est introuvable');
        }

        $isEditable = auth()->check() && auth()->user()->can('update', $freelance);

        if (!$isEditable && !$freelance->is_verified) {
            abort(404, 'Ce profil est introuvable, privé ou non vérifié.');
        }

        return Inertia::render('Freelance/Show', [
            'freelance'   => $freelance,
            'isEditable'  => $isEditable,
            'professions' => $isEditable ? Profession::orderBy('name')->get() : [],
            'skills'      => $isEditable ? Skill::orderBy('name')->get() : [],
        ]);
    }

    /*
     * Upload image into public storage and update the path in the database for freelance profile
     * */
    public function updateImage(Request $request, Freelance $freelance)
    {
        $request->validate([
            'cover'  => 'nullable|image',
            'avatar' => 'nullable|image',
        ]);

        $success = '';

        if ($request->hasFile('cover')) {
            if ($freelance->cover_picture) {
                Storage::disk('public')->delete($freelance->cover_picture);
                $freelance->update(['cover_picture' => null]);
            }
            $coverPath = $request->file('cover')->storeAs('freelances', $freelance->slug.'-cover', 'public');
            $freelance->update(['cover_picture' => Storage::url($coverPath)]);
            $success = 'Votre bannière a été mise à jour';
        }

        if ($request->hasFile('avatar')) {
            if ($freelance->profile_picture) {
                Storage::disk('public')->delete($freelance->profile_picture);
                $freelance->update(['profile_picture' => null]);
            }
            $avatarPath = $request->file('avatar')->storeAs('freelances', $freelance->slug.'-avatar', 'public');
            $freelance->update(['profile_picture' => Storage::url($avatarPath)]);
            $success = 'Votre photo de profil a été mise à jour';
        }

        return back()->with('success', $success);
    }

    public function updateLocation(Request $request, Freelance $freelance)
    {

        $validated = $request->validate([
            'location' => 'required|string|max:255',
        ]);

        $freelance->update(['location' => $validated['location']]);

        return back()->with('success', 'Votre localisation a été mise à jour');
    }

    public function updateProfessions(Request $request, Freelance $freelance)
    {
        $validated = $request->validate([
            'professions'   => ['nullable', 'array'],
            'professions.*' => ['exists:professions,id'],
        ]);

        $freelance->professions()->sync($validated['professions']);

        return back()->with('success', 'Métiers mis à jour.');
    }

    public function updateBio(Request $request, Freelance $freelance)
    {
        $request->validate([
            'bio' => 'nullable|string|max:2000',
        ]);

        $freelance->update(['bio' => $request->bio]);

        return back()->with('success', 'Votre bio a été mise à jour');
    }

    public function updateInfos(Request $request, Freelance $freelance)
    {
        $request->validate([
            'is_available'  => 'required|boolean',
            'price_per_day' => 'nullable|integer|min:0',
        ]);

        $freelance->update($request->only('is_available', 'price_per_day'));

        return back()->with('success', 'Informations mises à jour.');
    }

    public function updateSkills(Request $request, Freelance $freelance)
    {
        $validated = $request->validate([
            'skills'   => ['nullable', 'array'],
            'skills.*' => ['exists:skills,id'],
        ]);

        $freelance->skills()->sync($validated['skills']);

        return back()->with('success', 'Compétences mises à jour.');
    }

    public function verifyFreelance(Request $request)
    {

        $request->validate([
            'siret' => 'required|string|size:14',
            'identity_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $freelance = auth()->user()->freelance;

        $path = $request->file('identity_document')->storeAs('identity_documents', $freelance->slug . '-ID' , 'public');

        $freelance->update([
            'siret' => $request->siret,
            'identity_document_path' => Storage::url($path),
            'is_verified' => false
        ]);

        return back()->with('success', 'Vos informations ont bien été enregistrées. Votre compte sera vérifié sous peu.');
    }

}
