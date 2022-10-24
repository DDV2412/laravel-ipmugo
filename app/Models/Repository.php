<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repository extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repositories';

    protected $fillable = [
        'repoTitle',
        'repoDescription',
        'baseURL',
        'repoThumnail',
        'abbreviation',
        'adminEmail',
        'printISSN',
        'onlineISSN',
    ];

    public function article()
    {
        return $this->hasMany(ArticleRecord::class, 'repoId', 'id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'repoId', 'id');
    }

    public function scopeSearch($query, $val)
    {
        return $query
        ->where('repositories.id', 'like', '%'.$val.'%')
        ->orWhere('repositories.repoTitle', 'like', '%'.$val.'%')
        ->orWhere('repoDescription', 'like', '%'.$val.'%')
        ->orWhere('baseURL', 'like', '%'.$val.'%')
        ->orWhere('adminEmail', 'like', '%'.$val.'%')
        ->orWhere('abbreviation', 'like', '%'.$val.'%')
        ->orWhere('onlineISSN', 'like', '%'.$val.'%')
        ->orWhere('printISSN', 'like', '%'.$val.'%');
    }
}
