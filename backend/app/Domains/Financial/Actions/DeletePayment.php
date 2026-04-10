<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\PaymentRepository;
use App\Domains\Financial\Models\Payment;

class DeletePayment
{
    public function __construct(protected PaymentRepository $repo) {}

    public function execute(Payment $model): void
    {
        $this->repo->delete($model);
    }
}