<?php

namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Actions\CreateAccountBalance;
use App\Domains\Financial\Actions\DeleteAccountBalance;
use App\Domains\Financial\Actions\UpdateAccountBalance;
use App\Domains\Financial\DTOs\AccountBalanceData;
use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Http\Requests\StoreAccountBalanceRequest;
use App\Http\Requests\UpdateAccountBalanceRequest;
use Illuminate\Http\JsonResponse;

class AccountBalanceController
{
    public function __construct(
        protected AccountBalanceRepository $repo,
        protected CreateAccountBalance $create,
        protected UpdateAccountBalance $update,
        protected DeleteAccountBalance $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreAccountBalanceRequest $r): JsonResponse
    {
        $model = $this->create->execute(AccountBalanceData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateAccountBalanceRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            AccountBalanceData::fromArray($r->validated()),
            $this->repo->findOrFail($id)
        );
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->delete->execute($this->repo->findOrFail($id));
        return response()->json(null, 204);
    }
}