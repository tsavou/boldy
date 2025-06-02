<?php

namespace App\Http\Controllers;

use App\Enums\LinkTypeEnum;
use App\Models\FreelanceLink;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FreelanceLinkController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'string',
                'max:255',
                Rule::enum(LinkTypeEnum::class),
            ],
            'url' => 'required|url|max:255',
        ]);

        $freelance = auth()->user()->freelance;

        $freelance->links()->create($validated);

        return redirect()->back()->with('success', 'Lien ajouté avec succès');
    }

    public function update(Request $request, FreelanceLink $link)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'string',
                'max:255',
                Rule::enum(LinkTypeEnum::class),
            ],
            'url' => 'required|url|max:255',
        ]);

        $link->update($validated);

        return redirect()->back()->with('success', 'Lien mis à jour');
    }

    public function destroy(FreelanceLink $link)
    {
        $link->delete();

        return redirect()->back()->with('success', 'Lien supprimé');
    }
}
