<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';

    protected $fillable = [
        'repoId',
        'from',
        'until',
        'address',
        'listRecords',
        'countRecords',
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class, 'repoId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function scopeSearch($query, $val)
    {
        return $query
        ->where('repoId', 'like', '%'.$val.'%')
        ->orWhere('from', 'like', '%'.$val.'%')
        ->orWhere('until', 'like', '%'.$val.'%')
        ->orWhere('address', 'like', '%'.$val.'%')
        ->orWhere('listRecords', 'like', '%'.$val.'%')
        ->orWhere('countRecords', 'like', '%'.$val.'%');
    }
}
