<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->product_id = $product->id;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}