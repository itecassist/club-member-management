<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Financial\Models\AccountTransaction;

class AccountBalance extends Model
{
    use TenantScoped;
    protected $table = 'account_balances';
    protected $fillable = ['organisation_id', 'holder_type', 'holder_id', 'balance', 'currency_code', 'last_transaction_at'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class, 'account_balance_id');
    }

    public function holder()
    {
        return $this->morphTo();
    }

}