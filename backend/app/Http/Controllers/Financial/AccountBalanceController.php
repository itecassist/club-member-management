<?php
namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Domains\Financial\Actions\CreateAccountBalance;
use App\Domains\Financial\Actions\UpdateAccountBalance;
use App\Http\Requests\StoreAccountBalanceRequest;
use App\Http\Requests\UpdateAccountBalanceRequest;

class AccountBalanceController {
    public function __construct(
        protected AccountBalanceRepository $repo,
        protected CreateAccountBalance $create,
        protected UpdateAccountBalance $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreAccountBalanceRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateAccountBalanceRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}