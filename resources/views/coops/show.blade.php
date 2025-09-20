<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $coop->user->name }}'s Products</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">

    <!-- Breadcrumb -->
    <nav class="text-gray-600 mb-6 text-sm">
        <a href="{{ route('home') }}" class="hover:underline">Home</a> &gt;
        <a href="{{ route('coops.index') }}" class="hover:underline">Coops</a> &gt;
        <span class="font-semibold">{{ $coop->user->name }}</span>
    </nav>

    <!-- Coop Header -->
    <div class="flex items-center mb-8">
        <img src="{{ $coop->user->image ? asset('images/' . $coop->user->image) : asset('images/default-coop.jpg') }}"
             alt="{{ $coop->user->name }}"
             class="w-16 h-16 rounded-full mr-4 object-cover border-2 border-indigo-500">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $coop->user->name }}'s Products</h1>
            <p class="text-gray-600">{{ $coop->description }}</p>
            @if($coop->contact)
                <p class="text-gray-600 mt-1">Contact: {{ $coop->contact }}</p>
            @endif
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($coop->products as $product)

            @php
                $reviewsCount = $product->comments->count(); 
                $averageRating = $reviewsCount ? round($product->comments->avg('rating'), 1) : 0;
            @endphp

            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300 max-w-sm mx-auto">

                <!-- Product Image -->
                <div class="w-full h-40 flex items-center justify-center bg-gray-100 overflow-hidden">
                    <img loading="lazy" src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="max-h-full max-w-full object-contain">
                </div>

                <!-- Product Info -->
                <div class="p-3 flex flex-col flex-1">
                    <h2 class="text-lg font-semibold mb-1 text-gray-800 truncate">{{ $product->name }}</h2>

                    <!-- Reviews -->
                    <div class="flex items-center mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.288 3.946a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.288 3.945c.3.92-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.288-3.945a1 1 0 00-.364-1.118L2.073 9.373c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.288-3.946z"/>
                            </svg>
                        @endfor
                        <span class="ml-2 text-gray-600 text-sm">{{ $averageRating }}/5 ({{ $reviewsCount }} reviews)</span>
                    </div>

                    <!-- Comments Section Toggle -->
                    <details class="mb-2">
                        <summary class="cursor-pointer font-semibold text-indigo-600 text-sm">View Comments</summary>
                        <div class="mt-1 space-y-1 max-h-36 overflow-y-auto text-sm">
                            @forelse ($product->comments as $comment)
                                <div class="bg-gray-100 p-1 rounded">{{ $comment->comment }}</div>
                            @empty
                                <p class="text-gray-500 text-sm">No comments yet.</p>
                            @endforelse
                        </div>
                    </details>

                    <!-- Add Comment Form -->
                    <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <textarea name="comment" rows="2" class="w-full p-2 border rounded-lg text-gray-700 mb-2 text-sm" placeholder="Add a comment..." required></textarea>
                        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-1.5 px-4 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                            Post Comment
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <p class="text-gray-600 text-center col-span-3">No products found.</p>
        @endforelse
    </div>

</div>

</body>
</html>
