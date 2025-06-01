<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminFreelanceController extends Controller
{
    public function index()
    {
        $freelances = Freelance::where('is_verified', false)
            ->whereNotNull('siret')
            ->get();

        return Inertia::render('Admin/FreelancePendingList', [
            'freelances' => $freelances,
        ]);
    }

    public function approve(Freelance $freelance)
    {
        // Supprimer le document d'identité s'il existe pour éviter les fuites de données sensibles et respecter la RGPD
        if ($freelance->identity_document_path) {
            Storage::delete($freelance->identity_document_path);
            $freelance->identity_document_path = null;
        }

        $freelance->update([
            'is_verified' => true,
        ]);

        return back()->with('success', 'Freelance validé avec succès.');
    }
}
