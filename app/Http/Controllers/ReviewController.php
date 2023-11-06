<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Like;
use App\Comment;


class ReviewController extends Controller
{
    public function addLike($id)
    {
        $review = Review::find($id);
        $existingLike = $review->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $review->likes()->create(['user_id' => auth()->id()]);
        }

        return response()->json(['success' => true]);
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $review = Review::find($id);
        $review->comments()->create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return response()->json(['success' => true]);
    }
}