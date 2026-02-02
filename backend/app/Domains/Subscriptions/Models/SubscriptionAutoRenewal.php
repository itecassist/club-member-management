<?php

namespace App\Domains\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Subscriptions\Models\Subscription;

class SubscriptionAutoRenewal extends Model
{
    
    protected $table = 'subscription_auto_renewals';
    protected $fillable = ['subscription_id', 'enable_auto_renewal', 'apply_to_all_subscription_fees', 'payment_method', 'order_expiry_days', 'should_have_form', 'virtual_form_id', 'message'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

}