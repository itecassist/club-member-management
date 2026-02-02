<?php
namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Repositories\PaymentRepository;
use App\Domains\Financial\Actions\CreatePayment;
use App\Domains\Financial\Actions\UpdatePayment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController {
    public function __construct(
        protected PaymentRepository $repo,
        protected CreatePayment $create,
        protected UpdatePayment $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StorePaymentRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdatePaymentRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}