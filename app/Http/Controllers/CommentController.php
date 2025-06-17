<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Create a new comment
     */
    public function create(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => 'required|string|max:255',
            'coffee_id' => 'required|string'
        ]);
        $data['user_id'] = Auth::id();

        try {
            $comment = Comment::create($data);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Failed to create comment.'])->withInput();
        }

        return Redirect::back()->with('status', 'comment-created');
    }

    /**
     * Delete a comment
     */
    public function delete(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|string'
        ]);

        try {
            $comment = Comment::findOrFail($data['id']);

            if ($comment->user_id != Auth::id()) {
                return Redirect::back()->withErrors(['error' => 'Not your comment'])->withInput();
            }

            $comment->delete();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Failed to delete comment.']);
        }

        return Redirect::back()->with('status', 'comment-deleted');
    }
}
