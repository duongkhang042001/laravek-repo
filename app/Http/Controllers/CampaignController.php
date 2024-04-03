<?php

namespace App\Http\Controllers;

use App\Models\Campaign\Campaign;
use App\Abstracts\Http\Controllers\ApiController;
use App\Repositories\Campaign\CampaignRepository;
use App\Http\Requests\Campaign\CampaignIndexRequest;
use App\Http\Requests\Campaign\CampaignRequest as Request;
use App\Http\Resources\Campaign\Campaigns as CampaignCollection;

class CampaignController extends ApiController
{
    private $repository;

    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->repository = $campaignRepository;
    }

    public function index(CampaignIndexRequest $param)
    {
        return new CampaignCollection($this->repository->all($param->validated()));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function approve(string $id)
    {
        //
    }

    public function cancel(string $id)
    {
        //
    }

    public function confirm(string $id)
    {
        $this->repository->confirm($id);

        return $this->response->array([
            'success' => true,
            'message' => 'This campaign has been confirmed.'
        ]);
    }
}
