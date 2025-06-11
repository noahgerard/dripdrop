<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ContractsUser;
use Laravel\Socialite\Facades\Socialite;

class SSOController extends Controller
{
    /**
     * Redirect to appropriate oauth provider
     */
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle oauth callback
     */
    public function callback(string $provider): RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        $dbUser = User::where("{$provider}_id", $socialUser->getId())->first();

        if (!$dbUser) {
            $dbUser = $this->createUserFromSocialProvider($provider, $socialUser);
        }

        Auth::login($dbUser);

        return redirect()->intfended('/dashboard');
    }

    /**
     * Creates User record from SSO provider callback data
     * @param string $provider
     * @param mixed $socialUser
     * @return User
     */
    protected function createUserFromSocialProvider(string $provider, ContractsUser $socialUser): User
    {
        return User::create([
            'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Unknown',
            'email' => $socialUser->getEmail(),
            'department_id' => 0,
            'password' => bcrypt(Str::random(64)),
            'avatar' => $socialUser->getAvatar(),
            "{$provider}_id" => $socialUser->getId(),
        ]);
    }
}
