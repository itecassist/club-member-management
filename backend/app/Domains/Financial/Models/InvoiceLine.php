<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Financial\Models\Invoice;

class InvoiceLine extends Model
{
    
    protected $table = 'invoice_lines';
    protected $fillable = ['invoice_id', 'description', 'quantity', 'unit_price', 'tax_rate', 'amount'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

}