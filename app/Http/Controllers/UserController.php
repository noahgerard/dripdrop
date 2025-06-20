<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $departments = Department::pluck('name', 'id')->toArray();

        return view('profile.edit', [
            'user' => $request->user(),
            'departments' => $departments,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $randomName = uniqid('avatar_', true) . '.' . $avatar->getClientOriginalExtension();
            try {
                $s3Path = $avatar->storeAs('avatars', $randomName, 's3');
                $user->avatar = $s3Path;
            } catch (\Exception $e) {
                Log::error('Profile update: exception during S3 avatar upload', [
                    'random_name' => $randomName,
                    'user_id' => $user->id,
                    'size_bytes' => $avatar->getSize(),
                    'mime_type' => $avatar->getMimeType(),
                    'exception_message' => $e->getMessage(),
                ]);
                return Redirect::route('profile.edit')->withErrors(['avatar' => 'Failed to upload avatar: ' . $e->getMessage()]);
            }
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()->isSSO()) {
            if (!Session::pull('sso_reauthenticated')) {
                return Redirect::route('sso.redirect', ['reauth' => true, 'provider' => 'github']);
            }
        } else {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show a user profile and stats
     */
    public function show($id = null): View
    {
        $id ??= Auth::user()->id;

        // Validate that id is an integer
        if (!is_numeric($id) || intval($id) != $id) {
            abort(404);
        }

        $is_me = $id == Auth::user()->id;
        $user = $is_me ? Auth::user() : User::find($id);

        if (!$user) {
            abort(404);
        }

        $user_stats = $user->stats();
        $dep_stats = $user->department ? $user->department->stats() : [];

        // Chart data (last 30 days)
        $dates = collect(range(0, 29))->map(function ($i) {
            return now()->copy()->subDays(29 - $i)->toDateString();
        });

        // Fetch coffees consumed in last 30 days
        $coffeeCounts = $user->coffees()
            ->where('consumed_at', '>=', now()->copy()->subDays(29))
            ->get()
            ->groupBy(function ($coffee) {
                return $coffee->consumed_at->toDateString();
            });

        // Map dates to number of coffees that day
        $coffee_chart_data = $dates->map(function ($date) use ($coffeeCounts) {
            return [
                'date' => $date,
                'count' => isset($coffeeCounts[$date]) ? $coffeeCounts[$date]->count() : 0,
            ];
        });

        return view('user', [
            'user' => $user,
            'user_stats' => $user_stats,
            'dep_stats' => $dep_stats,
            'coffee_chart_data' => $coffee_chart_data,
            'is_me' => $is_me,
        ]);
    }
}
