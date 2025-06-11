<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ContractsUser;
use Laravel\Socialite\Facades\Socialite;

class SSOController extends Controller
{
    /**
     * Redirect to appropriate oauth provider
     */
    public function redirect(string $provider, string $reauth = '0'): RedirectResponse
    {
        if ($reauth == "1") {
            Session::put("sso_reauth_provider", $provider);
            return Socialite::driver($provider)->with(['prompt' => 'login'])->redirect();
        } else {
            return Socialite::driver($provider)->redirect();
        }
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

        // If reauth callback
        $reauth_provider = Session::pull('sso_reauth_provider');
        if ($reauth_provider) {
            Auth::login($dbUser);
            Session::put('sso_reauthenticated', true);
            return redirect()->route('profile.edit')->with('status', 'reauthenticated');
        } else {
            Auth::login($dbUser);
            return redirect()->intended('/dashboard');
        }
    }

    /**
     * Creates User record from SSO provider callback data
     * @param string $provider
     * @param mixed $socialUser
     * @return User
     */
    protected function createUserFromSocialProvider(string $provider, ContractsUser $socialUser): User
    {
        // Create user with no password
        return User::create([
            'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Unknown',
            'email' => $socialUser->getEmail(),
            'department_id' => 0,
            'avatar' => $socialUser->getAvatar(),
            "{$provider}_id" => $socialUser->getId(),
        ]);
    }
}
