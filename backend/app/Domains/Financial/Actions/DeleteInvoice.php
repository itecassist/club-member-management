<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Domains\Financial\Models\Invoice;

class DeleteInvoice
{
    public function __construct(protected InvoiceRepository $repo) {}

    public function execute(Invoice $model): void
    {
        $this->repo->delete($model);
    }
}