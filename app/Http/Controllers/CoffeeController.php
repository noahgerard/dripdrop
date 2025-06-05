<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Coffee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CoffeeController extends Controller
{
    /**
     * Create a coffee
     */
    public function create(Request $request): RedirectResponse
    {
        $data['user_id'] = $request->user()->id;
        $data['consumed_at'] = now();

        Coffee::create($data);

        // Log coffee creation
        Log::info('Coffee created', [
            'user_id' => $data['user_id'],
            'timestamp' => now()->toIso8601ZuluString(),
        ]);

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

        $coffee = Coffee::where([
            'id' => $data['id'],
            'user_id' => $request->user()->id,
        ])->first();

        if ($coffee) {
            $coffee->delete();

            // Log coffee deletion
            Log::info('Coffee deleted', [
                'user_id' => $request->user()->id,
                'coffee_id' => $data['id'],
                'timestamp' => now(),
            ]);

            return Redirect::route('dashboard')->with('status', 'coffee-deleted');
        } else {
            return Redirect::route('dashboard')->with('status', 'not-found');
        }
    }
}
