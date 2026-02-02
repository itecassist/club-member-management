<?php

namespace App\Domains\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Members\Models\Member;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Orders\Models\OrderItem;

class Order extends Model
{
    use TenantScoped;
    protected $table = 'orders';
    protected $fillable = ['member_id', 'organisation_id', 'name', 'email', 'payment_method', 'payment_reference', 'order_status', 'date_finished', 'comments', 'currency_code', 'currency_value', 'tax_total', 'total'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

}