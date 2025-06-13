<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Coffee;
use App\Models\User;
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
                'coffee_image' => 'nullable|image|max:4096', // changed to nullable
            ]);

            $data['is_custom'] = true;
            $data['title'] = $validated['title'];
            $data['desc'] = $validated['desc'];
            $data['type'] = $validated['coffee_type'];

            if ($request->hasFile('coffee_image')) {
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
                    $data['img_url'] = $response['data']['medium']['url'];
                    $data['del_img_url'] = $response['data']['delete_url'];
                } else {
                    Log::error('Image upload failed', [
                        'user_id' => $request->user()->id,
                        'response' => $response->json(),
                        'status' => $response->status(),
                    ]);
                    return back()->withErrors(['coffee_image' => 'Image upload failed.']);
                }
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

    /**
     * View a user's public coffee dashboard
     */
    public function userDashboard($id)
    {
        $user = User::with('department')->findOrFail($id);
        $user_stats = $user->stats();
        $dep_stats = $user->department ? $user->department->stats() : [];
        // Chart data (last 30 days)
        $dates = collect(range(0, 29))->map(function ($i) {
            return now()->copy()->subDays(29 - $i)->toDateString();
        });
        $coffeeCounts = $user->coffees()
            ->where('consumed_at', '>=', now()->copy()->subDays(29))
            ->get()
            ->groupBy(function ($coffee) {
                return $coffee->consumed_at->toDateString();
            });
        $coffee_chart_data = $dates->map(function ($date) use ($coffeeCounts) {
            return [
                'date' => $date,
                'count' => isset($coffeeCounts[$date]) ? $coffeeCounts[$date]->count() : 0,
            ];
        });
        return view('dashboard', [
            'user_stats' => $user_stats,
            'dep_stats' => $dep_stats,
            'coffee_chart_data' => $coffee_chart_data,
            'viewing_user' => $user,
        ]);
    }
}
