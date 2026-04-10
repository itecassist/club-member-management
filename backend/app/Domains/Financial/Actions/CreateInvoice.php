<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Domains\Financial\Models\Invoice;
use App\Domains\Financial\DTOs\InvoiceData;
use App\Domains\Financial\Events\InvoiceCreated;

class CreateInvoice
{
    public function __construct(protected InvoiceRepository $repo) {}

    public function execute(InvoiceData $data): Invoice
    {
        $model = $this->repo->create($data);
        event(new InvoiceCreated($model->id, $model->organisation_id));
        return $model;
    }
}