<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    protected $fillable = [
        'name',
        'email',
        'massage',
        'address',
        'countryName',
    ];

    public function scopeSearch($query, $val)
    {
        return $query
        ->where('id', 'like', '%'.$val.'%')
        ->orWhere('name', 'like', '%'.$val.'%')
        ->orWhere('email', 'like', '%'.$val.'%')
        ->orWhere('address', 'like', '%'.$val.'%')
        ->orWhere('address', 'like', '%'.$val.'%')
        ->orWhere('countryName', 'like', '%'.$val.'%');
    }
}
