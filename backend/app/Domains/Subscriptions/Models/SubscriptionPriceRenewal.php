<?php

namespace App\Domains\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Subscriptions\Models\Subscription;

class SubscriptionPriceRenewal extends Model
{
    
    protected $table = 'subscription_price_renewals';
    protected $fillable = ['subscription_id', 'name', 'price', 'tax_rate_id'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

}