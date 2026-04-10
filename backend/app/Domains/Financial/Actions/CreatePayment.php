<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\PaymentRepository;
use App\Domains\Financial\Models\Payment;
use App\Domains\Financial\DTOs\PaymentData;
use App\Domains\Financial\Events\PaymentCreated;

class CreatePayment
{
    public function __construct(protected PaymentRepository $repo) {}

    public function execute(PaymentData $data): Payment
    {
        $model = $this->repo->create($data);
        event(new PaymentCreated($model->id, $model->organisation_id));
        return $model;
    }
}