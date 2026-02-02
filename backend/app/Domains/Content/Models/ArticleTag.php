<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\Article;

class ArticleTag extends Model
{
    
    protected $table = 'article_tags';
    protected $fillable = ['article_id', 'tag'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}