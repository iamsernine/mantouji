<?php

namespace App\Http\Controllers;

use App\Models\JamInfo;
use Illuminate\Http\Request;

class CoopController extends Controller
{
    public function index()
    {
        // Eager load user and count products and reviews
        $coops = JamInfo::with('user')
            ->withCount([
                'products', // count of products
                'products as reviews_count' => function ($query) {
                    $query->withCount('comments'); // sum of comments
                }
            ])
            ->get();

        return view('coops.index', compact('coops'));
    }

    public function show(JamInfo $coop)
{
    $coop->load([
        'user',
        'products.comments.user', // only comments, no reviews
    ]);

    return view('coops.show', compact('coop'));
}
}
