<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try{
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->getId())->first();
            if($findUser)
            {
                Auth::login($findUser);
      
                return redirect()->route('redirects');
                
            }else{
                $newUser = User::create([
                    'username' => $user->user['email'],
                    'firstname' => $user->user['given_name'],
                    'lastname' => $user->user['family_name'],
                    'email' => $user->user['email'],
                    'password' => Hash::make($user->user['sub']),
                    'interest' => '',
                    'affiliation' => '',
                    'country' => $user->user['locale'],
                    'google_id' => $user->getId(),
                ]);

                $newUser->roles()->attach(Role::where('name', 'Reader')->first());
                Auth::login($newUser);
      
                return redirect()->route('redirects');
            }
        } catch(\Throwable $e)
        {
            return redirect()->route('login');
        }
    }
}
