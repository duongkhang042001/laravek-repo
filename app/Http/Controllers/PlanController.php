<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\IndexRequest;
use App\Repositories\Plan\PlanRepository;
use App\Abstracts\Http\Controllers\ApiController;
use App\Abstracts\Http\Controllers\IPlanController;
use App\Http\Resources\Plan\Plan as PlanResource;
use App\Http\Resources\Plan\Plans as PlanCollection;
use App\Http\Requests\Plan\UpdateRequest as UpdateRequest;

class PlanController extends ApiController  implements IPlanController
{
    private $repository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->repository = $planRepository;
    }

    public function index(IndexRequest $param)
    {
        return new PlanCollection($this->repository->all($param->validated()));
    }

    public function show(int $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new PlanResource($this->repository->find($id))
        ]);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new PlanResource($this->repository->update($request->validated(), $id))
        ]);
    }
}
