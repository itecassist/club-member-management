<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class PaymentMethod extends Model
{
    use TenantScoped;
    protected $table = 'payment_methods';
    protected $fillable = ['organisation_id', 'name', 'type', 'is_active', 'config'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}