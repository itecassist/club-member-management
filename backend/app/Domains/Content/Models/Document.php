<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    
    protected $table = 'documents';
    protected $fillable = ['documentable_type', 'documentable_id', 'name', 'path', 'type', 'size'];

    public function documentable()
    {
        return $this->morphTo();
    }

}