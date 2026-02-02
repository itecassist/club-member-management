<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class EmailTemplate extends Model
{
    use TenantScoped;
    protected $table = 'email_templates';
    protected $fillable = ['organisation_id', 'name', 'subject', 'body'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}