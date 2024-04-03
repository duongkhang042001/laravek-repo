<?php

namespace App\Http\Controllers;

use App\Models\Brandname\Brandname;
use App\Abstracts\Http\Controllers\ApiController;
use App\Repositories\Brandname\BrandnameConfigRepository;
use App\Http\Requests\Brandname\BrandnameConfigRequest as Request;

class BrandnameConfigController extends ApiController
{
    private $brandnameConfigRepository;

    public function __construct(BrandnameConfigRepository $brandnameConfigRepository)
    {
        $this->brandnameConfigRepository = $brandnameConfigRepository;
    }

    public function show(string $brandnameId)
    {
        $configs = $this->brandnameConfigRepository->all($brandnameId);

        return $configs;
    }

    public function update(Request $request, string $brandnameId)
    {
        $config = $this->brandnameConfigRepository->bulkUpdate($request->toArray(), $brandnameId);

        return $config;
    }
}
