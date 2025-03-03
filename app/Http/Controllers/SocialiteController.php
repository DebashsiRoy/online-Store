<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Guesser\Name;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Exception;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make('Pass#Key#@9865'), // Dummy password, not used for Google login
                ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard'); // Redirect to the dashboard or any route

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong!');
        }
    }

    // Method for facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = User::where('email', $facebookUser->getEmail())->first();
            if ($user){
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => Hash::make('Pass#Key#@9865'),
                    'facebook_id' => $facebookUser->id,
                ]);
            }
            Auth::login($user);
            return redirect()->route('dashboard'); // Redirect to the dashboard or any route
        }   catch (Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong!');
        }
    }

}














