<?php

namespace App\Repositories\Quota;

use Illuminate\Support\Facades\DB;
use App\Models\Quota\Quota as Model;
use Illuminate\Pagination\Paginator;
use App\Abstracts\Repository\BaseRepository;
use App\Abstracts\Repository\IQuotaRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class QuotaRepository extends BaseRepository implements IQuotaRepository
{
    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        $perPage = isset($filter['pageSize']) && !empty($filter['pageSize']) ? $filter['pageSize'] : 9;

        $page = Paginator::resolveCurrentPage('current');

        $qb = $this->model->select(['*']);

        if (isset($filter['partner_id'])) {
            $qb->where('partner_id', $filter['partner_id']);
        }

        if (isset($filter['quotas_current_usage'])) {
            $qb->where('quotas_current_usage', $filter['quotas_current_usage']);
        }

        if (isset($filter['quotas_limit'])) {
            $qb->where('quotas_limit', $filter['quotas_limit']);
        }

        $countQuery = "select count(*) as aggregate from ({$qb->toSql()}) c";

        $count = collect(DB::select($countQuery, $qb->getBindings()))->pluck('aggregate')->first();

        if ($count > 0) {
            $items = $qb->forPage($page, $perPage)->get();
        } else {
            $items = [];
        }

        $results = new LengthAwarePaginator($items, $count, $perPage, $page, [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]);

        $this->resetModel();

        return $results;
    }

    public function find($id)
    {
        $model = $this->model->find($id);

        $this->resetModel();

        return $model;
    }

    public function update($attributes, $id)
    {
        $this->model->where('id', $id)->update(['quotas_limit' => $attributes['quotas_limit']]);

        $this->resetModel();

        return $this->model->find($id);
    }

    public function delete($id)
    {
        //
    }

    public function create($attributes)
    {
        //
    }
}
