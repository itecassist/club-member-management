<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\Faq;

class FaqCategory extends Model
{
    
    protected $table = 'faq_categories';
    protected $fillable = ['name', 'description', 'live'];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }

}