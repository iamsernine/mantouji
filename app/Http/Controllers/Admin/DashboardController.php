<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Sector;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard admin avec statistiques
     */
    public function index()
    {
        $stats = [
            'cooperatives_count' => Cooperative::count(),
            'cooperatives_active' => Cooperative::where('is_active', true)->count(),
            'products_count' => Product::count(),
            'products_active' => Product::where('is_active', true)->count(),
            'users_count' => User::count(),
            'users_clients' => User::where('role', User::ROLE_CLIENT)->count(),
            'reviews_pending' => Review::where('is_approved', false)->count(),
            'reviews_total' => Review::count(),
            'sectors_count' => Sector::count(),
        ];

        // Dernières coopératives créées
        $recent_cooperatives = Cooperative::with('sector')
            ->latest()
            ->take(5)
            ->get();

        // Derniers produits ajoutés
        $recent_products = Product::with(['cooperative', 'sector'])
            ->latest()
            ->take(5)
            ->get();

        // Avis en attente de modération
        $pending_reviews = Review::with(['product', 'user'])
            ->where('is_approved', false)
            ->latest()
            ->take(10)
            ->get();

        // Statistiques par filière
        $sectors_stats = Sector::withCount(['products', 'cooperatives'])
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_cooperatives',
            'recent_products',
            'pending_reviews',
            'sectors_stats'
        ));
    }
}
