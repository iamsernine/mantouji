<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\CooperativeController as PublicCooperativeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CooperativeController as AdminCooperativeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Routes Publiques (sans authentification)
|--------------------------------------------------------------------------
*/

// Page d'accueil avec tous les produits et filtres
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages produits publiques
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

// Pages coopératives publiques
Route::get('/cooperatives', [PublicCooperativeController::class, 'index'])->name('cooperatives.index');
Route::get('/cooperatives/{cooperative}', [PublicCooperativeController::class, 'show'])->name('cooperatives.show');

/*
|--------------------------------------------------------------------------
| Routes Authentification (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Routes Clients Authentifiés (pour laisser des avis)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Soumettre un avis sur un produit
    Route::post('/products/{product}/reviews', [PublicProductController::class, 'storeReview'])
        ->name('products.reviews.store');
    
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Admin (gestion complète)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des coopératives
    Route::resource('cooperatives', AdminCooperativeController::class);
    Route::post('/cooperatives/{cooperative}/toggle-status', [AdminCooperativeController::class, 'toggleStatus'])
        ->name('cooperatives.toggle-status');
    
    // Gestion des produits
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');
    
    // Gestion des filières
    Route::resource('sectors', SectorController::class)->except(['show']);
    
    // Gestion des utilisateurs
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');
    
    // Gestion des avis (modération)
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Redirection du dashboard par défaut
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');
