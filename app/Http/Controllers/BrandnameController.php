<?php

namespace App\Http\Controllers;

use App\Abstracts\Http\Controllers\ApiController;
use App\Repositories\Brandname\BrandnameRepository;
use App\Http\Requests\Brandname\BrandnameIndexRequest;
use App\Http\Requests\Brandname\BrandnameRequest as Request;
use App\Http\Resources\Brandname\Brandname as BrandnameResource;

class BrandnameController extends ApiController
{
    private $brandnameRepository;

    public function __construct(BrandnameRepository $brandnameRepository)
    {
        $this->brandnameRepository = $brandnameRepository;
    }

    public function index(BrandnameIndexRequest $request)
    {
        return $this->brandnameRepository->all($request->validated());
    }

    public function store(Request $request)
    {
        $brandname = $this->brandnameRepository->create($request->validated());
        return $this->response->array([
            'success' => true,
            'data' => [
                'id' => $brandname->id
            ]
        ]);
    }

    public function show(string $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new BrandnameResource($this->brandnameRepository->find($id))
        ]);
    }

    public function update(Request $request, string $id)
    {
        $brandname = $this->brandnameRepository->update($id, $request->validated());
        return $this->response->array([
            'success' => true,
            'data' => [
                'id' => $brandname->id
            ]
        ]);
    }

    public function destroy(string $id)
    {
        $this->brandnameRepository->delete($id);
        return $this->response->array(['success' => true]);
    }
}
