@extends('layouts.public')

@section('title', 'Produits des Coopératives de Figuig')

@section('content')
<!-- Hero Section -->
<div class="gradient-oasis text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Produits Authentiques de Figuig</h1>
        <p class="text-xl text-gray-100 mb-8">Découvrez les trésors des coopératives de terroir</p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('home') }}" method="GET" class="flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Rechercher un produit..." 
                    class="flex-1 px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-gold"
                >
                <button type="submit" class="bg-gold text-white px-8 py-3 rounded-full hover:bg-desert-sand transition font-semibold">
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('home') }}" method="GET" class="flex flex-wrap gap-4 items-center">
            <!-- Preserve search -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            
            <!-- Filter by Cooperative -->
            <div class="flex-1 min-w-[200px]">
                <select name="cooperative_id" class="filter-dropdown w-full">
                    <option value="">Toutes les coopératives</option>
                    @foreach($cooperatives as $coop)
                        <option value="{{ $coop->id }}" {{ request('cooperative_id') == $coop->id ? 'selected' : '' }}>
                            {{ $coop->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter by Sector -->
            <div class="flex-1 min-w-[200px]">
                <select name="sector_id" class="filter-dropdown w-full">
                    <option value="">Toutes les filières</option>
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>
                            {{ $sector->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Sort -->
            <div class="flex-1 min-w-[200px]">
                <select name="sort" class="filter-dropdown w-full">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                </select>
            </div>
            
            <button type="submit" class="bg-oasis-green text-white px-6 py-2 rounded-lg hover:bg-palm-green transition font-semibold">
                Filtrer
            </button>
            
            @if(request()->hasAny(['cooperative_id', 'sector_id', 'sort', 'search']))
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-oasis-green transition">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="product-card">
                    <!-- Product Image -->
                    <a href="{{ route('products.show', $product) }}">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}"
                            class="product-card-image"
                        >
                    </a>
                    
                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Sector Badge -->
                        @if($product->sector)
                            <span class="inline-block bg-light-sand text-oasis-green text-xs px-3 py-1 rounded-full font-semibold mb-2">
                                {{ $product->sector->name }}
                            </span>
                        @endif
                        
                        <!-- Product Name -->
                        <h3 class="text-lg font-bold text-gray-800 mb-1">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-oasis-green transition">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <!-- Cooperative Name -->
                        <p class="text-sm text-gray-600 mb-2">
                            <a href="{{ route('cooperatives.show', $product->cooperative) }}" class="hover:text-oasis-green">
                                {{ $product->cooperative->name }}
                            </a>
                        </p>
                        
                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @php
                                    $rating = $product->averageRating();
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $rating ? 'text-gold' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">({{ $product->reviewsCount() }})</span>
                        </div>
                        
                        <!-- Price -->
                        @if($product->price)
                            <p class="text-xl font-bold text-oasis-green mb-3">{{ number_format($product->price, 2) }} MAD</p>
                        @endif
                        
                        <!-- WhatsApp Button -->
                        <a href="{{ $product->cooperative->whatsapp_url }}" target="_blank" class="whatsapp-button w-full justify-center text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Contacter
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun produit trouvé</h3>
            <p class="text-gray-500 mb-6">Essayez de modifier vos filtres de recherche</p>
            <a href="{{ route('home') }}" class="inline-block bg-oasis-green text-white px-6 py-3 rounded-lg hover:bg-palm-green transition">
                Voir tous les produits
            </a>
        </div>
    @endif
</div>
@endsection
