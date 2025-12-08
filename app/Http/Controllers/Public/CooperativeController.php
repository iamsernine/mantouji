<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use Illuminate\Http\Request;

class CooperativeController extends Controller
{
    /**
     * Afficher la liste des coopératives
     */
    public function index(Request $request)
    {
        $query = Cooperative::with('sector')
            ->where('is_active', true);

        // Filtre par filière
        if ($request->has('sector_id') && $request->sector_id != '') {
            $query->where('sector_id', $request->sector_id);
        }

        // Recherche
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cooperatives = $query->orderBy('name')->paginate(12);

        return view('public.cooperatives', compact('cooperatives'));
    }

    /**
     * Afficher les détails d'une coopérative
     */
    public function show(Cooperative $cooperative)
    {
        // Vérifier que la coopérative est active
        if (!$cooperative->is_active) {
            abort(404);
        }

        // Charger les produits actifs de la coopérative
        $cooperative->load([
            'sector',
            'products' => function($query) {
                $query->where('is_active', true)
                      ->with('sector')
                      ->latest();
            }
        ]);

        return view('public.cooperative', compact('cooperative'));
    }
}
