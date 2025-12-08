<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CooperativeController extends Controller
{
    /**
     * Afficher la liste des coopératives
     */
    public function index(Request $request)
    {
        $query = Cooperative::with('sector');

        // Filtres
        if ($request->has('sector_id') && $request->sector_id != '') {
            $query->where('sector_id', $request->sector_id);
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cooperatives = $query->latest()->paginate(15);
        $sectors = Sector::all();

        return view('admin.cooperatives.index', compact('cooperatives', 'sectors'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $sectors = Sector::all();
        return view('admin.cooperatives.create', compact('sectors'));
    }

    /**
     * Enregistrer une nouvelle coopérative
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'whatsapp' => 'required|string|max:20',
            'sector_id' => 'nullable|exists:sectors,id',
            'is_active' => 'boolean',
        ]);

        // Upload du logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('cooperatives/logos', 'public');
        }

        // Ajouter l'ID de l'admin qui crée
        $validated['created_by'] = Auth::id();

        $cooperative = Cooperative::create($validated);

        return redirect()
            ->route('admin.cooperatives.index')
            ->with('success', 'Coopérative créée avec succès.');
    }

    /**
     * Afficher les détails d'une coopérative
     */
    public function show(Cooperative $cooperative)
    {
        $cooperative->load(['sector', 'products', 'users']);
        return view('admin.cooperatives.show', compact('cooperative'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Cooperative $cooperative)
    {
        $sectors = Sector::all();
        return view('admin.cooperatives.edit', compact('cooperative', 'sectors'));
    }

    /**
     * Mettre à jour une coopérative
     */
    public function update(Request $request, Cooperative $cooperative)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'whatsapp' => 'required|string|max:20',
            'sector_id' => 'nullable|exists:sectors,id',
            'is_active' => 'boolean',
        ]);

        // Upload du nouveau logo si fourni
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo
            if ($cooperative->logo) {
                Storage::disk('public')->delete($cooperative->logo);
            }
            $validated['logo'] = $request->file('logo')->store('cooperatives/logos', 'public');
        }

        $cooperative->update($validated);

        return redirect()
            ->route('admin.cooperatives.index')
            ->with('success', 'Coopérative mise à jour avec succès.');
    }

    /**
     * Supprimer une coopérative
     */
    public function destroy(Cooperative $cooperative)
    {
        // Supprimer le logo
        if ($cooperative->logo) {
            Storage::disk('public')->delete($cooperative->logo);
        }

        $cooperative->delete();

        return redirect()
            ->route('admin.cooperatives.index')
            ->with('success', 'Coopérative supprimée avec succès.');
    }

    /**
     * Activer/Désactiver une coopérative
     */
    public function toggleStatus(Cooperative $cooperative)
    {
        $cooperative->update(['is_active' => !$cooperative->is_active]);

        return back()->with('success', 'Statut de la coopérative mis à jour.');
    }
}
