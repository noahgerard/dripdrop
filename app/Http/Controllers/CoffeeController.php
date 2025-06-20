<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CoffeeController extends Controller
{
    public function view($id)
    {
        // Validate that id is an integer
        if (!is_numeric($id) || intval($id) != $id) {
            abort(404);
        }
        $coffee = Coffee::find($id);

        if (!$coffee) {
            abort(404);
        }

        return view('view-coffee', ['coffee' => $coffee]);
    }

    public function form(Request $request)
    {
        return view('create-coffee');
    }

    /**
     * Create a coffee
     */
    public function create(Request $request): RedirectResponse
    {
        $data['user_id'] = $request->user()->id;
        $data['consumed_at'] = now();

        $types = config('app.coffee.types');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'coffee_type' => 'required|string|in:' . implode(',', array_keys($types)),
            'coffee_image' => 'nullable|image|max:600',
        ]);

        $data['title'] = $validated['title'];
        $data['desc'] = $validated['desc'];
        $data['type'] = $validated['coffee_type'];

        if ($request->hasFile('coffee_image')) {
            $image = $request->file('coffee_image');
            $randomName = uniqid('coffee_', true) . '.' . $image->getClientOriginalExtension();

            try {
                $s3Path = $image->storeAs('coffees', $randomName, 's3');

                $data['img_url'] = $s3Path;
            } catch (\Exception $e) {
                Log::error('Coffee create: exception during S3 upload', [
                    'random_name' => $randomName,
                    'user_id' => $request->user()->id,
                    'size_bytes' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                    'exception_message' => $e->getMessage(),
                ]);
                return Redirect::route('dashboard')->with('status', 's3-upload-exception');
            }
        }

        Coffee::create($data);

        return Redirect::route('dashboard')->with('status', 'coffee-created');
    }

    /**
     * Delete the user's coffee
     */
    public function delete(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|string'
        ]);

        if (!$data['id']) {
            return Redirect::route('dashboard')->with('status', 'no-id');
        }

        // Find coffee that matches ID and session user
        $coffee = Coffee::where([
            'id' => $data['id'],
            'user_id' => $request->user()->id,
        ])->first();

        if ($coffee) {
            if (!empty($coffee->img_url)) {
                // Delete image from S3
                try {
                    Storage::disk('s3')->delete($coffee->img_url);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete S3 image', [
                        'user_id' => $request->user()->id,
                        'coffee_id' => $data['id'],
                        'img_url' => $coffee->img_url,
                        'error' => $e->getMessage(),
                    ]);
                    return Redirect::route('dashboard')->with('status', 'error');
                }
            }

            $coffee->delete();

            return Redirect::route('dashboard')->with('status', 'coffee-deleted');
        } else {
            return Redirect::route('dashboard')->with('status', 'not-found');
        }
    }
}
