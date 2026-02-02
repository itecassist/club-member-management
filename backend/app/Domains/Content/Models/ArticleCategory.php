<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\Article;

class ArticleCategory extends Model
{
    
    protected $table = 'article_categories';
    protected $fillable = ['name', 'seo_name', 'description', 'live', 'article_live', 'section_id', 'tree_left', 'tree_right', 'tree_level'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }

}