<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cooperative;
use App\Models\Sector;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil avec tous les produits
     */
    public function index(Request $request)
    {
        $query = Product::with(['cooperative', 'sector'])
            ->where('is_active', true)
            ->whereHas('cooperative', function($q) {
                $q->where('is_active', true);
            });

        // Filtre par recherche
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        // Filtre par coopérative
        if ($request->has('cooperative_id') && $request->cooperative_id != '') {
            $query->where('cooperative_id', $request->cooperative_id);
        }

        // Filtre par filière
        if ($request->has('sector_id') && $request->sector_id != '') {
            $query->where('sector_id', $request->sector_id);
        }

        // Tri
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        // Données pour les filtres
        $cooperatives = Cooperative::active()->orderBy('name')->get();
        $sectors = Sector::orderBy('name')->get();

        return view('public.home', compact('products', 'cooperatives', 'sectors'));
    }
}
