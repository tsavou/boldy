<?php

namespace App\Http\Controllers;

use App\Models\FreelanceMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FreelanceMediaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'media' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:20000',
            'type'  => 'required|string|in:image,video',
        ]);

        $freelance = auth()->user()->freelance;

        $path = $request->file('media')->storeAs('freelances', $freelance->slug . '-' . $request->type . '-' . time(), 'public');

        $freelance->freelanceMedias()->create([
            'type' => $validated['type'],
            'url'  => Storage::url($path),
        ]);

        return back()->with('success', $request->type . ' ajouté avec succès.');
    }

    public function destroy(FreelanceMedia $media)
    {
        // Supprimer le fichier du stockage
        Storage::disk('public')->delete($media->url);

        // Supprimer la ligne de la base de données
        $media->delete();

        return back()->with('success', 'Média supprimé avec succès.');
    }
}
