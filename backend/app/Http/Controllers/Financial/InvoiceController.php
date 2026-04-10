<?php

namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Actions\CreateInvoice;
use App\Domains\Financial\Actions\DeleteInvoice;
use App\Domains\Financial\Actions\UpdateInvoice;
use App\Domains\Financial\DTOs\InvoiceData;
use App\Domains\Financial\Repositories\InvoiceRepository;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\JsonResponse;

class InvoiceController
{
    public function __construct(
        protected InvoiceRepository $repo,
        protected CreateInvoice $create,
        protected UpdateInvoice $update,
        protected DeleteInvoice $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreInvoiceRequest $r): JsonResponse
    {
        $model = $this->create->execute(InvoiceData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateInvoiceRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            InvoiceData::fromArray($r->validated()),
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