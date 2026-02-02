<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class TaxRate extends Model
{
    use TenantScoped;
    protected $table = 'tax_rates';
    protected $fillable = ['organisation_id', 'name', 'rate', 'is_default'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}