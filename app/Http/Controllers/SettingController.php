<?php

namespace App\Http\Controllers;

use App\Models\Core\Partner;
use App\Repositories\Core\SettingRepository;
use App\Abstracts\Http\Controllers\ApiController;
use App\Http\Requests\Core\SettingRequest as Request;
use App\Http\Resources\Core\Setting as SettingResource;

class SettingController extends ApiController
{
    private $repository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->repository = $settingRepository;
    }

    public function index($partner)
    {
        $settings = $this->repository->all($partner);

        return new SettingResource($settings);
    }

    public function update(Request $request, $partner)
    {
        $settings = $this->repository->bulkUpdate($request->validated(), $partner);

        return new SettingResource($settings);
    }
}
