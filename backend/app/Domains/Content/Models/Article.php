<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\ArticleCategory;
use App\Domains\Content\Models\ArticleTag;

class Article extends Model
{
    
    protected $table = 'articles';
    protected $fillable = ['type', 'title', 'article_category_id', 'page_title', 'seo_name', 'content', 'summary', 'seo_description', 'featured', 'live', 'category_live', 'popularity'];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function tags()
    {
        return $this->hasMany(ArticleTag::class, 'article_id');
    }

}