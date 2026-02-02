<?php

namespace App\Domains\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Forms\Models\VirtualForm;

class VirtualField extends Model
{
    
    protected $table = 'virtual_fields';
    protected $fillable = ['virtual_form_id', 'name', 'label', 'type', 'required', 'options', 'order'];

    public function virtualForm()
    {
        return $this->belongsTo(VirtualForm::class, 'virtual_form_id');
    }

}