<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popular extends Model
{
    use HasFactory;

    protected $table = 'populars';

    protected $fillable = [
        'article_id',
        'countryName',
        'address',
    ];

    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }
}
