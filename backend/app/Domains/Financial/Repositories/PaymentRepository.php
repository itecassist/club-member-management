<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\Payment;
use App\Domains\Financial\DTOs\PaymentData;

class PaymentRepository
{
    public function create(PaymentData $data): Payment
    {
        return Payment::create($data->toArray());
    }

    public function update(Payment $model, PaymentData $data): Payment
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function findOrFail(int $id): Payment
    {
        return Payment::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Payment::paginate($perPage);
    }

    public function delete(Payment $model): void
    {
        $model->delete();
    }
}