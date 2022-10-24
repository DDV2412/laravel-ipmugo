<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try{
            $user = Socialite::driver('facebook')->user();

            $findUser = User::where('facebook_id', $user->getId())->first();
            if($findUser)
            {
                Auth::login($findUser);
      
                return redirect()->route('redirects');
                
            }else{
                $newUser = User::create([
                    'username' => $user->getEmail(),
                    'firstname' => $user->getName(),
                    'lastname' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getId()),
                    'interest' => '',
                    'affiliation' => '',
                    'country' => '',
                    'facebook_id' => $user->getId(),
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
