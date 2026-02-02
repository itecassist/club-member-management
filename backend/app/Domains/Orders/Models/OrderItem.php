<?php

namespace App\Domains\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Orders\Models\Order;

class OrderItem extends Model
{
    
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'name', 'quantity', 'price', 'tax_rate', 'tax_amount', 'total'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}