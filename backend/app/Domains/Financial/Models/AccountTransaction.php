<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Financial\Models\AccountBalance;
use App\Domains\Auth\Models\User;

class AccountTransaction extends Model
{
    
    protected $table = 'account_transactions';
    protected $fillable = ['account_balance_id', 'type', 'amount', 'description', 'reference_type', 'reference_id', 'processed_by', 'processed_at'];

    public function accountBalance()
    {
        return $this->belongsTo(AccountBalance::class, 'account_balance_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function reference()
    {
        return $this->morphTo();
    }

}