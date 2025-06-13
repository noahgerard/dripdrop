<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Coffee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CoffeeController extends Controller
{
    public function view(Request $request): View
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


        if ($request->input('custom') == 'yes') {
            Log::info('', $data);

            $types = config('app.coffee.types');

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string|max:1000',
                'coffee_type' => 'required|string|in:' . implode(',', array_keys($types)),
                'coffee_image' => 'required|image|max:4096',
            ]);

            $data['is_custom'] = true;
            $data['title'] = $validated['title'];
            $data['desc'] = $validated['desc'];
            $data['type'] = $validated['coffee_type'];

            $image = $request->file('coffee_image');

            $apiKey = env('IMGBB_API_KEY');
            $uploadPath = $image->getRealPath();
            $uploadName = $image->getClientOriginalName();
            $response = Http::attach(
                'image',
                fopen($uploadPath, 'r'),
                $uploadName
            )->post('https://api.imgbb.com/1/upload', [
                'key' => $apiKey,
            ]);

            if ($response->successful() && isset($response['data']['url'], $response['data']['delete_url'])) {
                $data['img_url'] = $response['data']['thumb']['url'];
                $data['del_img_url'] = $response['data']['delete_url'];
            } else {
                return back()->withErrors(['coffee_image' => 'Image upload failed.']);
            }
        } else {
            Log::info('YEEEEE');
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

        $coffee = Coffee::where([
            'id' => $data['id'],
            'user_id' => $request->user()->id,
        ])->first();

        if ($coffee) {
            if ($coffee->is_custom && !empty($coffee->del_img_url)) {
                // Delete image from imgbb first
                try {
                    Http::delete($coffee->del_img_url);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete imgbb image', [
                        'user_id' => $request->user()->id,
                        'coffee_id' => $data['id'],
                        'del_img_url' => $coffee->del_img_url,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $coffee->delete();

            // Log coffee deletion
            Log::info('Coffee deleted', [
                'user_id' => $request->user()->id,
                'img' => $coffee->img_url,
                'del' => $coffee->del_img_url,
                'timestamp' => now(),
            ]);

            return Redirect::route('dashboard')->with('status', 'coffee-deleted');
        } else {
            return Redirect::route('dashboard')->with('status', 'not-found');
        }
    }
}
