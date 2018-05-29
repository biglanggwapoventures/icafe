<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Socialite;

class FacebookLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        if ($this->isExistingEmail($user->getEmail())) {

            $this->authenticateUsingEmail($user->getEmail());

        } else {

            $this->register([
                'provider' => 'facebook',
                'provider_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'display_photo' => $user->getAvatar(),
            ])->login();

        }

        return redirect('/');
    }

    public function isExistingEmail(string $email): bool
    {
        if (User::whereEmail($email)->exists()) {
            return true;
        }

        return false;
    }

    public function register(array $data): User
    {
        return User::create($data);
    }

    public function authenticateUsingEmail(string $email)
    {
        User::where('email', $email)->first()->login();
    }
}
