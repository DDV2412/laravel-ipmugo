<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Livewire\Frontend\Welcome::class)
    ->name('welcome');

Route::get('/journals', \App\Http\Livewire\Frontend\Journals::class)
    ->name('journals');

Route::get('/journal/{abbreviation}', \App\Http\Livewire\Frontend\JournalDetail::class)
    ->name('journalDetail');

Route::get('/articles', \App\Http\Livewire\Frontend\Articles::class)
    ->name('articles');

Route::get('/search', \App\Http\Livewire\Frontend\Search::class)
    ->name('search');

Route::get('/{abbreviation}/article/id/{id}', \App\Http\Livewire\Frontend\ArticleDetail::class)
    ->name('articleDetail');

Route::get('/about-us', \App\Http\Livewire\Frontend\AboutUs::class)
    ->name('about-us');

Route::get('/contact', \App\Http\Livewire\Frontend\Contact::class)
    ->name('contact');

    // Redirects
Route::get('/redirects', function () {
        $role = Auth::user()->roles->implode('name');
        if($role === 'Administrator'){
            return redirect()->route('admin.dashboard');
        }elseif($role === 'Assistent'){
            return redirect()->route('assistent.dashboard');
        }else{
            return redirect()->route('reader.dashboard');
        }
})->name('redirects');


// Auth Google
Route::get('/auth/google/redirect', [\App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('login.google');

Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);

// Auth GitHub
Route::get('/auth/github/redirect', [\App\Http\Controllers\GitHubController::class, 'redirectToGitHub'])->name('login.github');

Route::get('/auth/github/callback', [\App\Http\Controllers\GitHubController::class, 'handleGitHubCallback']);

// Facebook
Route::get('/auth/facebook/redirect', [\App\Http\Controllers\FacebookController::class, 'redirectToFacebook'])->name('login.facebook');

Route::get('/auth/facebook/callback', [\App\Http\Controllers\FacebookController::class, 'handleFacebookCallback']);

// Administrator

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
                            'auth:sanctum',
                            'verified',
                            'role:Administrator'
                        ],
    ],
    function(){

    // Dashboard
    //----------------------------------
    Route::get('/dashboard', [
        'as' => 'admin.dashboard',
        'uses' => \App\Http\Livewire\Backend\Admin\Dashboard::class,
    ]);
    
    // Repository
    //----------------------------------
    Route::get('/repository', [
        'as' => 'admin.repository',
        'uses' => \App\Http\Livewire\Backend\Admin\Respository::class,
    ]);

    Route::get('/repository/{id}', [
        'as' => 'admin.repositoryId',
        'uses' => \App\Http\Livewire\Backend\Admin\RepositoryDetail::class,
    ]);

    // User
    Route::get('/users', [
        'as' => 'admin.users',
        'uses' => \App\Http\Livewire\Backend\Admin\User::class,
    ]);
    // Chart
    Route::get('/chart', [
        'as' => 'admin.chart',
        'uses' => \App\Http\Livewire\Backend\Admin\Chart::class,
    ]);
    // Contact
    Route::get('/contact', [
        'as' => 'admin.contact',
        'uses' => \App\Http\Livewire\Backend\Admin\Contact::class,
    ]);
    // Profile
    Route::get('/profile', [
        'as' => 'admin.profile',
        'uses' => \App\Http\Livewire\Backend\Admin\Profile::class,
    ]);

    Route::get('/history/{abbreviation}', [
        'as' => 'admin.history',
        'uses' => \App\Http\Livewire\Backend\Admin\History::class,
    ]);
});

// Assistent

Route::group(
    [
        'prefix' => 'assistent',
        'middleware' => [
                            'auth:sanctum',
                            'verified',
                            'role:Assistent'
                        ],
    ],
    function(){

    // Dashboard
    //----------------------------------
    Route::get('/dashboard', [
        'as' => 'assistent.dashboard',
        'uses' => \App\Http\Livewire\Backend\Admin\Dashboard::class,
    ]);
    
    // Repository
    //----------------------------------
    Route::get('/repository', [
        'as' => 'assistent.repository',
        'uses' => \App\Http\Livewire\Backend\Admin\Respository::class,
    ]);

    Route::get('/repository/{id}', [
        'as' => 'assistent.repositoryId',
        'uses' => \App\Http\Livewire\Backend\Admin\RepositoryDetail::class,
    ]);

    // User
    Route::get('/users', [
        'as' => 'assistent.users',
        'uses' => \App\Http\Livewire\Backend\Assistent\User::class,
    ]);
    // Chart
    Route::get('/chart', [
        'as' => 'assistent.chart',
        'uses' => \App\Http\Livewire\Backend\Admin\Chart::class,
    ]);
    // Contact
    Route::get('/contact', [
        'as' => 'assistent.contact',
        'uses' => \App\Http\Livewire\Backend\Admin\Contact::class,
    ]);
    // Profile
    Route::get('/profile', [
        'as' => 'assistent.profile',
        'uses' => \App\Http\Livewire\Backend\Admin\Profile::class,
    ]);
    Route::get('/history/{abbreviation}', [
        'as' => 'assistent.history',
        'uses' => \App\Http\Livewire\Backend\Admin\History::class,
    ]);
});

Route::group(
    [
        'prefix' => 'user',
        'middleware' => [
                            'auth:sanctum',
                            'verified',
                            'role:Reader'
                        ],
    ],
    function(){

    // Dashboard
    //----------------------------------
    Route::get('/dashboard', [
        'as' => 'reader.dashboard',
        'uses' => \App\Http\Livewire\Backend\Reader\Dashboard::class,
    ]);

    Route::get('/library', [
        'as' => 'reader.library',
        'uses' => \App\Http\Livewire\Backend\Reader\Library::class,
    ]);
    // Profile
    Route::get('/profile', [
        'as' => 'reader.profile',
        'uses' => \App\Http\Livewire\Backend\Reader\Profile::class,
    ]);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('redirects');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');