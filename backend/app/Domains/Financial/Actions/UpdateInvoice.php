<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Domains\Financial\Models\Invoice;
use App\Domains\Financial\DTOs\InvoiceData;

class UpdateInvoice
{
    public function __construct(protected InvoiceRepository $repo) {}

    public function execute(InvoiceData $data, Invoice $model): Invoice
    {
        return $this->repo->update($model, $data);
    }
}