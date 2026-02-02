<?php

namespace App\Domains\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Subscriptions\Models\SubscriptionPriceOption;
use App\Domains\Subscriptions\Models\SubscriptionPriceRenewal;
use App\Domains\Subscriptions\Models\SubscriptionPriceLateFee;
use App\Domains\Subscriptions\Models\SubscriptionAutoRenewal;

class Subscription extends Model
{
    use TenantScoped;
    protected $table = 'subscriptions';
    protected $fillable = ['organisation_id', 'name', 'description', 'virtual_form_id', 'document_id', 'membership', 'membership_type', 'period', 'renewals', 'published'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function priceOptions()
    {
        return $this->hasMany(SubscriptionPriceOption::class, 'subscription_id');
    }

    public function priceRenewals()
    {
        return $this->hasMany(SubscriptionPriceRenewal::class, 'subscription_id');
    }

    public function priceLateFees()
    {
        return $this->hasMany(SubscriptionPriceLateFee::class, 'subscription_id');
    }

    public function autoRenewal()
    {
        return $this->hasOne(SubscriptionAutoRenewal::class, 'subscription_id');
    }

}