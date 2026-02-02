<?php
namespace App\Domains\Financial\Actions;
use App\Domains\Financial\Repositories\PaymentRepository;
use App\Domains\Financial\Models\Payment;

class UpdatePayment {
    public function __construct(protected PaymentRepository $repo) {}
    public function execute(array $data, Payment $model = null): Payment {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}