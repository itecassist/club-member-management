<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\PaymentRepository;
use App\Domains\Financial\Models\Payment;
use App\Domains\Financial\DTOs\PaymentData;

class UpdatePayment
{
    public function __construct(protected PaymentRepository $repo) {}

    public function execute(PaymentData $data, Payment $model): Payment
    {
        return $this->repo->update($model, $data);
    }
}