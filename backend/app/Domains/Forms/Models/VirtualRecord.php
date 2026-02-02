<?php

namespace App\Domains\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Forms\Models\VirtualForm;

class VirtualRecord extends Model
{
    
    protected $table = 'virtual_records';
    protected $fillable = ['virtual_form_id', 'recordable_type', 'recordable_id', 'data'];

    public function virtualForm()
    {
        return $this->belongsTo(VirtualForm::class, 'virtual_form_id');
    }

    public function recordable()
    {
        return $this->morphTo();
    }

}