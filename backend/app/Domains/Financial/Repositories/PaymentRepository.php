<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\Payment;

class PaymentRepository
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function update(Payment $model, array $data): Payment
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Payment::paginate($perPage);
    }
}