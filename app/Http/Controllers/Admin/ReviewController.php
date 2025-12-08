<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Afficher la liste des avis
     */
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user']);

        // Filtres
        if ($request->has('is_approved') && $request->is_approved != '') {
            $query->where('is_approved', $request->is_approved);
        }

        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Approuver un avis
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    /**
     * Rejeter un avis
     */
    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);

        return back()->with('success', 'Avis rejeté.');
    }

    /**
     * Supprimer un avis
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Avis supprimé avec succès.');
    }
}
