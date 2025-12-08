<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectorController extends Controller
{
    /**
     * Afficher la liste des filières
     */
    public function index()
    {
        $sectors = Sector::withCount(['products', 'cooperatives'])->get();
        return view('admin.sectors.index', compact('sectors'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.sectors.create');
    }

    /**
     * Enregistrer une nouvelle filière
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sectors',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        // Upload de l'icône
        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('sectors/icons', 'public');
        }

        Sector::create($validated);

        return redirect()
            ->route('admin.sectors.index')
            ->with('success', 'Filière créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Sector $sector)
    {
        return view('admin.sectors.edit', compact('sector'));
    }

    /**
     * Mettre à jour une filière
     */
    public function update(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sectors,name,' . $sector->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        // Upload de la nouvelle icône si fournie
        if ($request->hasFile('icon')) {
            // Supprimer l'ancienne icône
            if ($sector->icon) {
                Storage::disk('public')->delete($sector->icon);
            }
            $validated['icon'] = $request->file('icon')->store('sectors/icons', 'public');
        }

        $sector->update($validated);

        return redirect()
            ->route('admin.sectors.index')
            ->with('success', 'Filière mise à jour avec succès.');
    }

    /**
     * Supprimer une filière
     */
    public function destroy(Sector $sector)
    {
        // Vérifier si la filière est utilisée
        if ($sector->products()->count() > 0 || $sector->cooperatives()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette filière car elle est utilisée.');
        }

        // Supprimer l'icône
        if ($sector->icon) {
            Storage::disk('public')->delete($sector->icon);
        }

        $sector->delete();

        return redirect()
            ->route('admin.sectors.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}
