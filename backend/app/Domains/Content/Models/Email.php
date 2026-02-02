<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class Email extends Model
{
    use TenantScoped;
    protected $table = 'emails';
    protected $fillable = ['organisation_id', 'to', 'subject', 'body', 'status', 'sent_at'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}