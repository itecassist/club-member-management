<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Members\Models\Member;
use App\Domains\Financial\Models\InvoiceLine;
use App\Domains\Financial\Models\Payment;

class Invoice extends Model
{
    use TenantScoped;
    protected $table = 'invoices';
    protected $fillable = ['organisation_id', 'member_id', 'invoice_number', 'issue_date', 'due_date', 'status', 'subtotal', 'tax_total', 'total', 'currency_code'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function lines()
    {
        return $this->hasMany(InvoiceLine::class, 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

}