<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Afficher les détails d'un produit
     */
    public function show(Product $product)
    {
        // Vérifier que le produit est actif
        if (!$product->is_active || !$product->cooperative->is_active) {
            abort(404);
        }

        // Charger les relations
        $product->load([
            'cooperative.sector',
            'sector',
            'reviews' => function($query) {
                $query->where('is_approved', true)
                      ->with('user')
                      ->latest();
            }
        ]);

        // Calculer les statistiques des avis
        $reviewsStats = [
            'average' => $product->averageRating(),
            'count' => $product->reviewsCount(),
            'distribution' => [
                5 => $product->reviews()->where('rating', 5)->count(),
                4 => $product->reviews()->where('rating', 4)->count(),
                3 => $product->reviews()->where('rating', 3)->count(),
                2 => $product->reviews()->where('rating', 2)->count(),
                1 => $product->reviews()->where('rating', 1)->count(),
            ]
        ];

        // Autres produits de la même coopérative
        $relatedProducts = $product->otherProductsFromSameCooperative(4);

        // Vérifier si l'utilisateur a déjà laissé un avis
        $userReview = null;
        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('public.product', compact(
            'product',
            'reviewsStats',
            'relatedProducts',
            'userReview'
        ));
    }

    /**
     * Soumettre un avis sur un produit
     */
    public function storeReview(Request $request, Product $product)
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour laisser un avis.');
        }

        // Vérifier que l'utilisateur n'a pas déjà laissé un avis
        $existingReview = $product->reviews()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Vous avez déjà laissé un avis sur ce produit.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_approved' => false, // En attente de modération
        ]);

        return back()->with('success', 'Votre avis a été soumis et est en attente de modération.');
    }
}
