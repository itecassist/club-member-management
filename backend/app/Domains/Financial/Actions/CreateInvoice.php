<?php
namespace App\Domains\Financial\Actions;
use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Domains\Financial\Models\Invoice;

class CreateInvoice {
    public function __construct(protected InvoiceRepository $repo) {}
    public function execute(array $data, Invoice $model = null): Invoice {
        $model = $this->repo->create($data);
        return $model;
    }
}