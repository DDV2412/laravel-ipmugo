<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'article_id',
        'firstname',
        'lastname',
        'affiliations',
        'email',
    ];
    
    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }

    public function scopeSearch($query, $val)
    {
        return $query
        ->where('name', 'like', '%'.$val.'%');
    }
}
