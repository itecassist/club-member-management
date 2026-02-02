<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Content\Models\Faq;

class FaqTag extends Model
{
    
    protected $table = 'faq_tags';
    protected $fillable = ['faq_id', 'tag'];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faq_id');
    }

}