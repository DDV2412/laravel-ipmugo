<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaveArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'save_articles';

    protected $fillable = [
        'article_id',
        'user_id',
        'address',
        'countryName',
    ];

    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }
}
