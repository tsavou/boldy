<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificationRequest;
use App\Models\Certification;

class CertificationController extends Controller
{
    public function store(CertificationRequest $request)
    {
        $freelance = auth()->user()->freelance;

        $freelance->certifications()->create($request->validated());

        return redirect()->back()->with('success', 'Certification ajoutée avec succès');
    }

    public function update(CertificationRequest $request, Certification $certification)
    {

        $certification->update($request->validated());

        return redirect()->back()->with('success', 'Certification mise à jour avec succès');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->back()->with('success', 'Certification supprimée avec succès');
    }
}
