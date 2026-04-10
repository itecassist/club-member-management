<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\Invoice;
use App\Domains\Financial\DTOs\InvoiceData;

class InvoiceRepository
{
    public function create(InvoiceData $data): Invoice
    {
        return Invoice::create($data->toArray());
    }

    public function update(Invoice $model, InvoiceData $data): Invoice
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function findOrFail(int $id): Invoice
    {
        return Invoice::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Invoice::paginate($perPage);
    }

    public function delete(Invoice $model): void
    {
        $model->delete();
    }
}