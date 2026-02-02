<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\FaqCategory;
use App\Domains\Content\Models\FaqTag;

class Faq extends Model
{
    
    protected $table = 'faqs';
    protected $fillable = ['question', 'answer', 'faq_category_id', 'live', 'popularity'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function tags()
    {
        return $this->hasMany(FaqTag::class, 'faq_id');
    }

}