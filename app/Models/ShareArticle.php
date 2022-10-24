<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareArticle extends Model
{
    use HasFactory;

    protected $table = 'share_articles';

    protected $fillable = [
        'article_id',
        'sosial',
        'address',
        'countryName',
    ];

    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }
}
