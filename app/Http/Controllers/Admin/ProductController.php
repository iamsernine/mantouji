<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cooperative;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Afficher la liste des produits
     */
    public function index(Request $request)
    {
        $query = Product::with(['cooperative', 'sector']);

        // Filtres
        if ($request->has('cooperative_id') && $request->cooperative_id != '') {
            $query->where('cooperative_id', $request->cooperative_id);
        }

        if ($request->has('sector_id') && $request->sector_id != '') {
            $query->where('sector_id', $request->sector_id);
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(20);
        $cooperatives = Cooperative::active()->get();
        $sectors = Sector::all();

        return view('admin.products.index', compact('products', 'cooperatives', 'sectors'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $cooperatives = Cooperative::active()->get();
        $sectors = Sector::all();
        return view('admin.products.create', compact('cooperatives', 'sectors'));
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sector_id' => 'nullable|exists:sectors,id',
            'cooperative_id' => 'required|exists:cooperatives,id',
            'is_active' => 'boolean',
        ]);

        // Upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Afficher les détails d'un produit
     */
    public function show(Product $product)
    {
        $product->load(['cooperative', 'sector', 'reviews.user']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Product $product)
    {
        $cooperatives = Cooperative::active()->get();
        $sectors = Sector::all();
        return view('admin.products.edit', compact('product', 'cooperatives', 'sectors'));
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sector_id' => 'nullable|exists:sectors,id',
            'cooperative_id' => 'required|exists:cooperatives,id',
            'is_active' => 'boolean',
        ]);

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Product $product)
    {
        // Supprimer l'image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    /**
     * Activer/Désactiver un produit
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Statut du produit mis à jour.');
    }
}
