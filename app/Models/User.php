<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable 
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saluation',
        'username',
        'firstname',
        'midlename',
        'lastname',
        'email',
        'orcid',
        'scopus_id',
        'publons',
        'linkend_in',
        'interest',
        'department',
        'affiliation',
        'address',
        'country',
        'bio',
        'password',
        'google_id',
        'facebook_id',
        'twitter_id',
        'gitHub_id',
        'auth_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->where('name', $roles)->first();
    }

    public function hasAnyRoles(array $roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function isOnline(){
        return Cache::has('user-is-online-'. $this->id);
    }

    public function history()
    {
        return $this->hasMany(History::class, 'user_id', 'id');
    }

    public function scopeSearch($query, $val)
    {
        return $query
        ->where('id', 'like', '%'.$val.'%')
        ->orWhere('username', 'like', '%'.$val.'%')
        ->orWhere('firstname', 'like', '%'.$val.'%')
        ->orWhere('lastname', 'like', '%'.$val.'%')
        ->orWhere('orcid', 'like', '%'.$val.'%')
        ->orWhere('scopus_id', 'like', '%'.$val.'%')
        ->orWhere('publons', 'like', '%'.$val.'%')
        ->orWhere('linkend_in', 'like', '%'.$val.'%')
        ->orWhere('interest', 'like', '%'.$val.'%')
        ->orWhere('affiliation', 'like', '%'.$val.'%')
        ->orWhere('address', 'like', '%'.$val.'%')
        ->orWhere('country', 'like', '%'.$val.'%');
    }
}
