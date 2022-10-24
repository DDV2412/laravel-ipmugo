<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleRecord extends Model
{
    use HasFactory;
    
    protected $table = 'article_records';

    protected $fillable = [
        'repoId',
        'identifier',
        'title',
        'description',
        'publisher',
        'repoTitle',
        'issue',
        'volume',
        'nomor',
        'pages',
        'date',
        'year',
        'doi',
        'file_PDF'
    ];

    public function subject()
    {
        return $this->hasMany(Subject::class, 'article_id', 'id');
    }
    
    public function saveArticle()
    {
        return $this->hasMany(SaveArticle::class, 'article_id', 'id');
    }

    public function shareArticle()
    {
        return $this->hasMany(ShareArticle::class, 'article_id', 'id');
    }

    public function citeArticle()
    {
        return $this->hasMany(CiteArticle::class, 'article_id', 'id');
    }

    public function downArticle()
    {
        return $this->hasMany(DownArticle::class, 'article_id', 'id');
    }

    public function author()
    {
        return $this->hasMany(Author::class, 'article_id', 'id');
    }

    public function popular()
    {
        return $this->hasMany(Popular::class, 'article_id', 'id');
    }


    public function repository()
    {
        return $this->belongsTo(Repository::class, 'repoId', 'id');
    }

    public function scopeSearch($query, $val)
    {
        return $query
        ->where('article_records.id', 'like', '%'.$val.'%')
        ->orWhere('article_records.repoId', 'like', '%'.$val.'%')
        ->orWhere('article_records.title', 'like', '%'.$val.'%')
        ->orWhere('description', 'like', '%'.$val.'%')
        ->orWhere('article_records.repoTitle', 'like', '%'.$val.'%')
        ->orWhere('issue', 'like', '%'.$val.'%')
        ->orWhere('volume', 'like', '%'.$val.'%')
        ->orWhere('nomor', 'like', '%'.$val.'%')
        ->orWhere('pages', 'like', '%'.$val.'%')
        ->orWhere('year', 'like', '%'.$val.'%')
        ->orWhere('doi', 'like', '%'.$val.'%');
    }
}
