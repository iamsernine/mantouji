<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits de {{ $coop->user->name }}</title>
    @vite('resources/css/app.css')
    <style>
        .star {
            font-size: 1.2rem;
            cursor: pointer;
            color: #ccc;
            transition: color 0.2s;
            outline: none;
        }
        .star.selected,
        .star.hovered {
            color: #facc15; /* yellow-400 */
        }
        .star:focus {
            outline: 2px solid #facc15;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-2 sm:px-4 py-6">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="relative flex justify-center items-center mb-8">
        <a href="{{ route('coops.index') }}" 
           class="absolute left-0 text-gray-600 hover:text-gray-800 transition-colors flex items-center text-sm font-semibold hover:underline">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
             <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
           </svg>
           Retour aux Coopératives
        </a>
        <img src="{{ asset('images/mantouj-removebg-preview.png') }}" 
              alt="Logo Mantouj" 
              class="h-16 object-contain">
    </div>
    
    <div class="flex flex-col sm:flex-row items-center mb-8"> 
        <img src="{{ $coop->user->image ? asset('images/' . $coop->user->image) : asset('images/default-coop.jpg') }}"
              alt="{{ $coop->user->name }}"
              class="w-20 h-20 rounded-full mr-0 sm:mr-6 mb-4 sm:mb-0 object-cover border-4 border-orange-600 flex-shrink-0">
        <div class="text-center sm:text-left">
            <h1 class="text-3xl font-extrabold text-gray-800">Produits de {{ $coop->user->name }}</h1>
            <p class="text-gray-600 mt-1 italic">{{ $coop->description }}</p>
            @if($coop->contact)
                <p class="text-gray-600 text-sm mt-2 font-medium">
                    <span class="font-semibold text-orange-600">Contact:</span> {{ $coop->contact }}
                </p>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 min-w-[320px]" style="min-width: 320px;">
        @forelse ($coop->products as $product)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden p-2 sm:p-4 w-full max-w-xs mx-auto">

                <div class="w-full h-48 flex items-center justify-center bg-white overflow-hidden p-2">
                    <img loading="lazy" src="{{ asset('storage/products/' . basename($product->image)) }}"
                          alt="{{ $product->name }}"
                          class="max-h-full max-w-full object-contain" />
                </div>

                <div class="flex flex-col flex-grow">
                    <h2 class="text-xl font-bold mb-2 text-gray-800 truncate">{{ $product->name }}</h2>

                    @php 
                        $avgRating = round($product->averageRating(), 1); 
                        $userHasReviewed = auth()->check() && $product->comments()
                                                ->where('user_id', auth()->id())
                                                ->where('rating', '>', 0) 
                                                ->exists();
                    @endphp
                    
                    <div class="flex items-center mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($avgRating) ? 'text-yellow-500' : 'text-gray-300' }} text-lg">&#9733;</span>
                        @endfor
                        <span class="ml-2 text-gray-600 font-semibold text-sm">{{ $avgRating }}/5 </span>
                        <span class="text-gray-500 text-xs">({{ $product->reviewsCount() }} avis)</span>
                    </div>

                    <details class="mb-4">
                        <summary class="cursor-pointer font-semibold text-orange-600 hover:text-orange-700 text-sm focus:outline-none">Voir les Commentaires & Avis</summary>
                        <div class="mt-3 space-y-3 max-h-48 overflow-y-auto pr-2 text-sm border-t pt-2">
                            @forelse ($product->comments as $comment)
                                <div class="flex items-start bg-gray-50 p-3 rounded-lg border">
                                    <img src="{{ $comment->user && $comment->user->image ? asset('images/' . $comment->user->image) : asset('images/default-user.jpg') }}"
                                          alt="{{ $comment->user ? $comment->user->name : 'Utilisateur Supprimé' }}"
                                          class="w-7 h-7 rounded-full mr-3 object-cover flex-shrink-0">
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between">
                                            <p class="text-gray-800 font-bold">{{ $comment->user ? $comment->user->name : 'Utilisateur Supprimé' }}</p>
                                            @if($comment->rating > 0)
                                                <div class="flex text-yellow-500 text-sm">
                                                    @for($i=1; $i<=5; $i++)
                                                        <span class="{{ $i <= $comment->rating ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</span>
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                        @if($comment->comment)
                                            <p class="text-gray-700 mt-1">{{ $comment->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center">Aucun commentaire/avis pour le moment.</p>
                            @endforelse
                        </div>
                    </details>
                    
                    @if(auth()->check())
                        <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            
                            @if(!$userHasReviewed)
                                <div class="flex mb-2 stars-container" data-product-id="{{ $product->id }}">
                                    <span class="text-sm font-medium text-gray-700 mr-2">Note:</span>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star" data-value="{{ $i }}" role="button" tabindex="0" aria-label="Donner {{ $i }} étoile{{ $i > 1 ? 's' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" value="0" id="rating-{{ $product->id }}">
                            @else
                                <div class="p-2 mb-2 text-center bg-gray-100 border border-gray-300 rounded-lg">
                                    <p class="text-sm font-semibold text-gray-700">✅ Votre note est enregistrée. Vous pouvez commenter à nouveau ci-dessous.</p>
                                </div>
                                <input type="hidden" name="rating" value="0"> 
                            @endif

                            <textarea name="comment" rows="2" 
                                      class="w-full p-2 border border-gray-300 rounded-lg text-gray-700 mb-2 text-sm focus:ring-orange-500 focus:border-orange-500" 
                                      placeholder="{{ $userHasReviewed ? 'Ajouter un autre commentaire simple (sans note)...' : 'Ajouter un commentaire ou un avis...' }}"></textarea>
                            
                            <button type="submit"
                                class="w-full bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                Publier
                            </button>
                        </form>
                    @else
                        <div class="mt-auto p-3 text-center bg-yellow-50 border border-yellow-300 rounded-lg">
                            <p class="text-sm font-medium text-yellow-700">Connectez-vous pour laisser un avis.</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center col-span-full py-10 text-xl font-medium">Aucun produit trouvé pour {{ $coop->user->name }}.</p>
        @endforelse
    </div>
    </div>
</div>

<script>
// Improved accessibility and keyboard support for star rating
document.querySelectorAll('.stars-container').forEach(container => {
    if (container.closest('form')) { 
        const stars = container.querySelectorAll('.star');
        const productId = container.dataset.productId;
        const hiddenInput = document.getElementById('rating-' + productId);
        let currentRating = 0; 

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                currentRating = index + 1;
                hiddenInput.value = currentRating;
                updateStars();
            });

            star.addEventListener('mouseover', () => {
                 stars.forEach(s => s.classList.remove('hovered')); 
                 for (let i = 0; i <= index; i++) {
                     stars[i].classList.add('hovered');
                 }
            });

            star.addEventListener('focus', () => {
                stars.forEach(s => s.classList.remove('hovered'));
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add('hovered');
                }
            });

            star.addEventListener('blur', () => {
                stars.forEach(s => s.classList.remove('hovered'));
                updateStars();
            });

            star.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    currentRating = index + 1;
                    hiddenInput.value = currentRating;
                    updateStars();
                }
                // Arrow key navigation
                if (e.key === 'ArrowLeft' && index > 0) {
                    stars[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < stars.length - 1) {
                    stars[index + 1].focus();
                }
            });

            container.addEventListener('mouseleave', () => {
                 stars.forEach(s => s.classList.remove('hovered'));
                 updateStars();
            });
        });

        function updateStars() {
            stars.forEach((s, i) => {
                s.classList.remove('selected');
                s.classList.remove('hovered');
                if (i < currentRating) {
                    s.classList.add('selected');
                }
            });
        }
    }
});
</script>

</body>
</html>