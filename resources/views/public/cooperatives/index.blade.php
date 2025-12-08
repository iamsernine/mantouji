@extends('layouts.public')

@section('title', 'Coopératives')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-oasis-green mb-4">Nos Coopératives</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Découvrez les coopératives de terroir de Figuig qui perpétuent les traditions et savoir-faire ancestraux.
        </p>
    </div>

    <!-- Cooperatives Grid -->
    @if($cooperatives->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cooperatives as $cooperative)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <!-- Logo -->
                    <div class="h-48 bg-gradient-to-br from-oasis-green to-palm-green flex items-center justify-center">
                        @if($cooperative->logo)
                            <img src="{{ Storage::url($cooperative->logo) }}" alt="{{ $cooperative->name }}" class="h-32 w-32 object-contain">
                        @else
                            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center">
                                <span class="text-4xl font-bold text-oasis-green">{{ substr($cooperative->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $cooperative->name }}</h3>
                        
                        @if($cooperative->sector)
                            <span class="inline-block px-3 py-1 bg-gold bg-opacity-20 text-gold text-sm rounded-full mb-3">
                                {{ $cooperative->sector->name }}
                            </span>
                        @endif

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $cooperative->description ?? 'Coopérative de terroir de Figuig' }}
                        </p>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $cooperative->products_count ?? 0 }} produits</span>
                            @if($cooperative->location)
                                <span>📍 {{ $cooperative->location }}</span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="{{ route('cooperatives.show', $cooperative) }}" class="flex-1 text-center bg-oasis-green text-white px-4 py-2 rounded-lg hover:bg-palm-green transition">
                                Voir les produits
                            </a>
                            @if($cooperative->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cooperative->whatsapp) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($cooperatives->hasPages())
            <div class="mt-12">
                {{ $cooperatives->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucune coopérative disponible</h3>
            <p class="text-gray-600">Les coopératives seront bientôt ajoutées.</p>
        </div>
    @endif
</div>
@endsection
