<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'article_id',
        'subject'
    ];
    
    public function article()
    {
        return $this->belongsTo(ArticleRecord::class, 'article_id', 'id');
    }
}
