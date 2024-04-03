<?php

namespace App\Http\Controllers;

use App\Models\Core\Partner;
use App\Repositories\Core\PartnerRepository;
use App\Abstracts\Http\Controllers\ApiController;
use App\Http\Requests\Core\PartnerIndexRequest;
use App\Http\Requests\Core\PartnerRequest as Request;
use App\Http\Resources\Core\Partner as PartnerResource;
use App\Http\Resources\Core\Partners as PartnerCollection;


class PartnerController extends ApiController
{
    private $repository;

    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->repository = $partnerRepository;
    }

    public function index(PartnerIndexRequest $param)
    {
        return new PartnerCollection($this->repository->all($param->validated()));
    }

    public function store(Request $request)
    {
        return $this->response->array([
            'success' => true,
            'data' => new PartnerResource($this->repository->create($request->validated()))
        ]);
    }

    public function show(string $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new PartnerResource($this->repository->find($id))
        ]);
    }

    public function update(Request $request, string $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new PartnerResource($this->repository->update($id, $request->validated()))
        ]);
    }

    public function destroy(string $id)
    {
        $this->repository->delete($id);

        return $this->response->array(['success' => true]);
    }
}
