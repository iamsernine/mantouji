@extends('layouts.public')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8 text-sm">
        <ol class="flex items-center space-x-2 text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-oasis-green">Accueil</a></li>
            <li>/</li>
            @if($product->sector)
                <li><a href="{{ route('home', ['sector_id' => $product->sector->id]) }}" class="hover:text-oasis-green">{{ $product->sector->name }}</a></li>
                <li>/</li>
            @endif
            <li class="text-gray-800 font-medium">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Product Image -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <img 
                    src="{{ $product->image_url }}" 
                    alt="{{ $product->name }}"
                    class="w-full h-[500px] object-cover"
                >
            </div>
        </div>
        
        <!-- Product Info -->
        <div>
            <!-- Sector Badge -->
            @if($product->sector)
                <span class="inline-block bg-light-sand text-oasis-green text-sm px-4 py-2 rounded-full font-semibold mb-4">
                    {{ $product->sector->name }}
                </span>
            @endif
            
            <!-- Product Name -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="flex items-center mb-6">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $reviewsStats['average'] ? 'text-gold' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span class="ml-3 text-gray-600">
                    <span class="font-bold text-gray-900">{{ number_format($reviewsStats['average'], 1) }}</span> 
                    ({{ $reviewsStats['count'] }} avis)
                </span>
            </div>
            
            <!-- Price -->
            @if($product->price)
                <div class="mb-6">
                    <span class="text-4xl font-bold text-oasis-green">{{ number_format($product->price, 2) }} MAD</span>
                </div>
            @endif
            
            <!-- Short Description -->
            @if($product->short_description)
                <p class="text-lg text-gray-700 mb-6">{{ $product->short_description }}</p>
            @endif
            
            <!-- Cooperative Info -->
            <div class="bg-light-sand rounded-xl p-6 mb-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">VENDU PAR</h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4">
                            @if($product->cooperative->logo)
                                <img src="{{ $product->cooperative->logo_url }}" alt="{{ $product->cooperative->name }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="text-2xl font-bold text-oasis-green">{{ substr($product->cooperative->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">
                                <a href="{{ route('cooperatives.show', $product->cooperative) }}" class="hover:text-oasis-green">
                                    {{ $product->cooperative->name }}
                                </a>
                            </h4>
                            @if($product->cooperative->sector)
                                <p class="text-sm text-gray-600">{{ $product->cooperative->sector->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- WhatsApp Button -->
            <a href="{{ $product->cooperative->whatsapp_url }}" target="_blank" class="whatsapp-button w-full justify-center text-lg mb-4">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Contacter sur WhatsApp
            </a>
            
            <!-- Contact Info -->
            <div class="text-sm text-gray-600 space-y-1">
                @if($product->cooperative->email)
                    <p>📧 {{ $product->cooperative->email }}</p>
                @endif
                @if($product->cooperative->website)
                    <p>🌐 <a href="{{ $product->cooperative->website }}" target="_blank" class="text-oasis-green hover:underline">{{ $product->cooperative->website }}</a></p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Long Description -->
    @if($product->long_description)
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Description</h2>
            <div class="prose prose-lg max-w-none text-gray-700">
                {!! nl2br(e($product->long_description)) !!}
            </div>
        </div>
    @endif
    
    <!-- Reviews Section -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Avis des clients</h2>
        
        <!-- Reviews Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
            <!-- Average Rating -->
            <div class="text-center">
                <div class="text-6xl font-bold text-oasis-green mb-2">{{ number_format($reviewsStats['average'], 1) }}</div>
                <div class="flex items-center justify-center mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $reviewsStats['average'] ? 'text-gold' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-gray-600">Basé sur {{ $reviewsStats['count'] }} avis</p>
            </div>
            
            <!-- Rating Distribution -->
            <div class="space-y-2">
                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 w-12">{{ $i }} ★</span>
                        <div class="flex-1 h-4 bg-gray-200 rounded-full mx-3 overflow-hidden">
                            @php
                                $percentage = $reviewsStats['count'] > 0 ? ($reviewsStats['distribution'][$i] / $reviewsStats['count']) * 100 : 0;
                            @endphp
                            <div class="h-full bg-gold" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12 text-right">{{ $reviewsStats['distribution'][$i] }}</span>
                    </div>
                @endfor
            </div>
        </div>
        
        <!-- Add Review Form -->
        @auth
            @if(!$userReview)
                <div class="bg-light-sand rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Laisser un avis</h3>
                    <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                        @csrf
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Votre note *</label>
                            <div class="flex items-center space-x-2" x-data="{ rating: 0 }">
                                @for($i = 1; $i <= 5; $i++)
                                    <button 
                                        type="button"
                                        @click="rating = {{ $i }}"
                                        class="focus:outline-none"
                                    >
                                        <svg 
                                            class="w-8 h-8 cursor-pointer transition"
                                            :class="rating >= {{ $i }} ? 'text-gold' : 'text-gray-300'"
                                            fill="currentColor" 
                                            viewBox="0 0 20 20"
                                        >
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" x-model="rating" required>
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Votre commentaire (optionnel)</label>
                            <textarea 
                                name="comment" 
                                id="comment" 
                                rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-oasis-green"
                                placeholder="Partagez votre expérience avec ce produit..."
                            >{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="bg-oasis-green text-white px-6 py-3 rounded-lg hover:bg-palm-green transition font-semibold">
                            Publier mon avis
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8">
                    <p class="text-green-700">Vous avez déjà laissé un avis sur ce produit.</p>
                </div>
            @endif
        @else
            <div class="bg-light-sand rounded-xl p-6 mb-8 text-center">
                <p class="text-gray-700 mb-4">Connectez-vous pour laisser un avis</p>
                <a href="{{ route('login') }}" class="inline-block bg-oasis-green text-white px-6 py-3 rounded-lg hover:bg-palm-green transition font-semibold">
                    Se connecter
                </a>
            </div>
        @endauth
        
        <!-- Reviews List -->
        @if($product->reviews->count() > 0)
            <div class="space-y-6">
                @foreach($product->reviews as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-oasis-green rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-gold' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-8">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
        @endif
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Autres produits de {{ $product->cooperative->name }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="product-card">
                        <a href="{{ route('products.show', $related) }}">
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="product-card-image">
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">
                                <a href="{{ route('products.show', $related) }}" class="hover:text-oasis-green transition">
                                    {{ $related->name }}
                                </a>
                            </h3>
                            @if($related->price)
                                <p class="text-xl font-bold text-oasis-green">{{ number_format($related->price, 2) }} MAD</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
