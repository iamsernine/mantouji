@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card: Coopératives -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-oasis-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Coopératives</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['cooperatives_count'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['cooperatives_active'] }} actives</p>
            </div>
            <div class="w-12 h-12 bg-oasis-green bg-opacity-10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-oasis-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Stat Card: Produits -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-desert-sand">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Produits</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['products_count'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['products_active'] }} actifs</p>
            </div>
            <div class="w-12 h-12 bg-desert-sand bg-opacity-10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-desert-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Stat Card: Utilisateurs -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-terracotta">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Utilisateurs</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['users_count'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stats['users_clients'] }} clients</p>
            </div>
            <div class="w-12 h-12 bg-terracotta bg-opacity-10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Stat Card: Avis en attente -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gold">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Avis en attente</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['reviews_pending'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stats['reviews_total'] }} total</p>
            </div>
            <div class="w-12 h-12 bg-gold bg-opacity-10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Dernières coopératives -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Dernières coopératives</h3>
        <div class="space-y-3">
            @forelse($recent_cooperatives as $coop)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-oasis-green rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($coop->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-800">{{ $coop->name }}</p>
                            <p class="text-xs text-gray-500">{{ $coop->sector->name ?? 'Sans filière' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.cooperatives.show', $coop) }}" class="text-oasis-green hover:text-palm-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Aucune coopérative</p>
            @endforelse
        </div>
        <a href="{{ route('admin.cooperatives.index') }}" class="block text-center mt-4 text-oasis-green hover:text-palm-green font-medium">
            Voir toutes les coopératives →
        </a>
    </div>
    
    <!-- Derniers produits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Derniers produits</h3>
        <div class="space-y-3">
            @forelse($recent_products as $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-desert-sand rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->cooperative->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.show', $product) }}" class="text-oasis-green hover:text-palm-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Aucun produit</p>
            @endforelse
        </div>
        <a href="{{ route('admin.products.index') }}" class="block text-center mt-4 text-oasis-green hover:text-palm-green font-medium">
            Voir tous les produits →
        </a>
    </div>
</div>

<!-- Avis en attente de modération -->
@if($pending_reviews->count() > 0)
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Avis en attente de modération</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pending_reviews as $review)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $review->product->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-gold' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($review->comment, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approuver</button>
                        </form>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Supprimer cet avis ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('admin.reviews.index') }}" class="block text-center mt-4 text-oasis-green hover:text-palm-green font-medium">
        Voir tous les avis →
    </a>
</div>
@endif
@endsection
