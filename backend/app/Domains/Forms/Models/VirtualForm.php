<?php

namespace App\Domains\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Forms\Models\VirtualField;
use App\Domains\Forms\Models\VirtualRecord;

class VirtualForm extends Model
{
    use TenantScoped;
    protected $table = 'virtual_forms';
    protected $fillable = ['organisation_id', 'name', 'description'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function fields()
    {
        return $this->hasMany(VirtualField::class, 'virtual_form_id');
    }

    public function records()
    {
        return $this->hasMany(VirtualRecord::class, 'virtual_form_id');
    }

}