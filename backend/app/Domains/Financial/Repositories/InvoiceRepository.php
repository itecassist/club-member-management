<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\Invoice;

class InvoiceRepository
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function update(Invoice $model, array $data): Invoice
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Invoice::paginate($perPage);
    }
}