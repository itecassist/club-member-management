<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Members\Models\Member;
use App\Domains\Financial\Models\Invoice;

class Payment extends Model
{
    use TenantScoped;
    protected $table = 'payments';
    protected $fillable = ['organisation_id', 'member_id', 'invoice_id', 'payment_date', 'amount', 'payment_method', 'reference', 'status'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

}