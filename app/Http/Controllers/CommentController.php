<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
            // Notify the owner of the coffee post if not the commenter
            $coffee = Coffee::find($data['coffee_id']);
            if ($coffee && $coffee->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $coffee->user_id,
                    'type' => 'comment',
                    'data' => [
                        'comment_id' => $comment->id,
                        'coffee_id' => $coffee->id,
                        'content' => $comment->content,
                        'from_user_id' => Auth::id(),
                        'from_user_name' => Auth::user()->name,
                    ],
                ]);
            }
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
