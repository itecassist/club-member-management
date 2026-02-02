<?php
namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Domains\Financial\Actions\CreateInvoice;
use App\Domains\Financial\Actions\UpdateInvoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;

class InvoiceController {
    public function __construct(
        protected InvoiceRepository $repo,
        protected CreateInvoice $create,
        protected UpdateInvoice $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreInvoiceRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateInvoiceRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}