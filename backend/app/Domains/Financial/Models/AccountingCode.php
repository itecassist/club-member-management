<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Tenancy\Models\OrganisationConfigFinancial;

class AccountingCode extends Model
{
    
    protected $table = 'accounting_codes';
    protected $fillable = ['organisation_config_financial_id', 'code', 'description'];

    public function organisationConfigFinancial()
    {
        return $this->belongsTo(OrganisationConfigFinancial::class, 'organisation_config_financial_id');
    }

}