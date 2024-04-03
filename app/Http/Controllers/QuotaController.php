<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quota\IndexRequest;
use App\Repositories\Quota\QuotaRepository;
use App\Abstracts\Http\Controllers\ApiController;
use App\Abstracts\Http\Controllers\IQuotaController;
use App\Http\Resources\Quota\Quota as QuotaResource;
use App\Http\Resources\Quota\Quotas as QuotaCollection;
use App\Http\Requests\Quota\UpdateRequest as UpdateRequest;

class QuotaController extends ApiController  implements IQuotaController
{
    private $repository;

    public function __construct(QuotaRepository $quotaRepository)
    {
        $this->repository = $quotaRepository;
    }

    public function index(IndexRequest $param)
    {
        return new QuotaCollection($this->repository->all($param->validated()));
    }

    public function show(int $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new QuotaResource($this->repository->find($id))
        ]);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new QuotaResource($this->repository->update($request->validated(), $id))
        ]);
    }
}
