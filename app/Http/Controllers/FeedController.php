<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * Fetches feed and returns feed view
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request): View
    {
        $coffees = Coffee::with(['user.department'])->orderBy('consumed_at', 'desc')->paginate(10);

        return view('feed', ['coffees' => $coffees]);
    }
}
