<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GitHubController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try{
            $user = Socialite::driver('github')->user();

            $findUser = User::where('gitHub_id', $user->getId())->first();
            if($findUser)
            {
                Auth::login($findUser);
      
                return redirect()->route('redirects');
                
            }else{
                $newUser = User::create([
                    'username' => $user->user['login'],
                    'firstname' => $user->user['name'],
                    'lastname' => $user->user['name'],
                    'email' => $user->user['email'],
                    'password' => Hash::make($user->user['node_id']),
                    'interest' => '',
                    'affiliation' => '',
                    'country' => '',
                    'gitHub_id' => $user->getId(),
                    'auth_type' => $user->user['type'],
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
