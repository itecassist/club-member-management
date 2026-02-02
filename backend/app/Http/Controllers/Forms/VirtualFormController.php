<?php
namespace App\Http\Controllers\Forms;

use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Domains\Forms\Actions\CreateVirtualForm;
use App\Domains\Forms\Actions\UpdateVirtualForm;
use App\Http\Requests\StoreVirtualFormRequest;
use App\Http\Requests\UpdateVirtualFormRequest;

class VirtualFormController {
    public function __construct(
        protected VirtualFormRepository $repo,
        protected CreateVirtualForm $create,
        protected UpdateVirtualForm $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreVirtualFormRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateVirtualFormRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}