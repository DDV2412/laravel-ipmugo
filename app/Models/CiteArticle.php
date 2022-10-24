<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiteArticle extends Model
{
    use HasFactory;

    protected $table = 'cite_articles';

    protected $fillable = [
        'article_id',
        'address',
        'countryName',
    ];

    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }
}
