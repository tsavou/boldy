<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use App\Models\Freelance;
use App\Models\Profession;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $boosted = Freelance::query()
            ->whereHas('boosts', function ($query) {
                $query->where('end_date', '>', now());
                $query->where('start_date', '<', now());
            })
            ->with('user', 'professions')
            ->get();

        $categories = Profession::query()
            ->withCount('freelances')
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
