<?php

namespace App\Domains\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Subscriptions\Models\Subscription;

class SubscriptionPriceLateFee extends Model
{
    
    protected $table = 'subscription_price_late_fees';
    protected $fillable = ['subscription_id', 'days_after_due', 'fee_amount', 'tax_rate_id'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

}