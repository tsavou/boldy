<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use App\Models\Profession;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $boosted = Freelance::boosted()
            ->with('professions')
            ->get();

        $categories = Profession::query()
            ->withCount(['freelances'])
            ->orderBy('freelances_count', 'desc')
            ->get();

        $freelancesCount = Freelance::count();

        return Inertia::render('Home', [
            'boosted' => $boosted,
            'categories' => $categories,
            'freelancesCount' => $freelancesCount,
        ]);
    }
}
