@extends('layouts.public')

@section('title', $cooperative->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Cooperative Header -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Logo -->
            <div class="flex-shrink-0">
                @if($cooperative->logo)
                    <img src="{{ Storage::url($cooperative->logo) }}" alt="{{ $cooperative->name }}" class="w-32 h-32 object-contain rounded-lg">
                @else
                    <div class="w-32 h-32 bg-gradient-oasis rounded-lg flex items-center justify-center">
                        <span class="text-5xl font-bold text-white">{{ substr($cooperative->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $cooperative->name }}</h1>
                        @if($cooperative->sector)
                            <span class="inline-block px-4 py-1 bg-gold bg-opacity-20 text-gold text-sm rounded-full">
                                {{ $cooperative->sector->name }}
                            </span>
                        @endif
                    </div>
                    
                    @if($cooperative->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cooperative->whatsapp) }}" target="_blank" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Contacter
                        </a>
                    @endif
                </div>

                @if($cooperative->description)
                    <p class="text-gray-600 mb-4">{{ $cooperative->description }}</p>
                @endif

                <!-- Contact Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @if($cooperative->location)
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-oasis-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $cooperative->location }}
                        </div>
                    @endif

                    @if($cooperative->phone)
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-oasis-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $cooperative->phone }}
                        </div>
                    @endif

                    @if($cooperative->email)
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-oasis-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $cooperative->email }}
                        </div>
                    @endif

                    @if($cooperative->website)
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-oasis-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <a href="{{ $cooperative->website }}" target="_blank" class="text-oasis-green hover:underline">
                                Site web
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produits de la coopérative</h2>

        @if($cooperative->products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cooperative->products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        <!-- Product Image -->
                        <div class="h-48 bg-gray-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-desert-sand to-gold">
                                    <span class="text-4xl">📦</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            
                            @if($product->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                            @endif

                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-oasis-green">{{ number_format($product->price, 2) }} DH</span>
                                @if($product->average_rating)
                                    <div class="flex items-center gap-1">
                                        <span class="text-gold">★</span>
                                        <span class="text-sm font-medium">{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('products.show', $product) }}" class="block w-full text-center bg-oasis-green text-white px-4 py-2 rounded-lg hover:bg-palm-green transition">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12 bg-white rounded-xl">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun produit disponible</h3>
                <p class="text-gray-600">Cette coopérative n'a pas encore ajouté de produits.</p>
            </div>
        @endif
    </div>
</div>
@endsection
