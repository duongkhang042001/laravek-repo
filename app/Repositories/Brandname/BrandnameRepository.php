<?php

namespace App\Repositories\Brandname;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Abstracts\Repository\BaseRepository;
use App\Models\Brandname\Brandname as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Abstracts\Repository\IBrandnameRepository;
use Illuminate\Container\Container as Application;
use App\Repositories\Brandname\BrandnameConfigRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class BrandnameRepository extends BaseRepository implements IBrandnameRepository
{
    function model()
    {
        return Model::class;
    }

    protected $brandnameConfigRepository;

    protected $permissionRepository;

    public function __construct(
        Application $app,
        CacheRepository $cache,
        BrandnameConfigRepository $brandnameConfigRepository,

    ) {
        parent::__construct($app, $cache);

        $this->brandnameConfigRepository = $brandnameConfigRepository;
    }

    public function all($filter = [])
    {
        $perPage = isset($filter['pageSize']) && !empty($filter['pageSize']) ? $filter['pageSize'] : 9;

        $page = Paginator::resolveCurrentPage('current');

        $qb = $this->model->select(['id', 'name', 'enabled', 'created_at', 'updated_at']);

        if (isset($filter['from']) && isset($filter['to'])) {
            $qb->where(function ($q) use ($filter) {
                $q->where('created_at', '>=', date('Y-m-d', strtotime($filter['from'])))
                    ->where('created_at', '<', date('Y-m-d', strtotime($filter['to'] . ' +1 day')));
            });
        }

        if (!empty($filter['name'])) {
            $qb->where('name', 'like', $filter['name'] . '%');
        }

        if (isset($filter['enabled'])) {
            $qb->where('enabled', $filter['enabled']);
        }

        if (isset($filter['order']) && isset($filter['sort'])) {
            $qb->orderBy($filter['order'], $filter['sort']);
        }

        // Sort
        $defaultSortField = isset($filter['sort']) ? $filter['sort'] :  'created_at';
        $defaultSortOrder = isset($filter['order']) ? $filter['order'] :  'descend';

        $qb->orderBy($defaultSortField, core()->parseOrder($defaultSortOrder));

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

    public function create($attributes)
    {
        $model = $this->model->create([
            'name' => $attributes['name']
        ]);

        $this->resetModel();

        return $model;
    }

    public function find($id)
    {
        $model = $this->model->findOrFail($id);

        $this->resetModel();

        return $model;
    }

    public function update($id, $attributes)
    {
        $model = $this->model->findOrFail($id);

        $model->update($attributes);

        $this->resetModel();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        $this->resetModel();

        $deleted = $model->delete();

        $this->resetModel();

        return $deleted;
    }

    public function getAllWithCache($id, $attributes)
    {
        $brandnames = $this->cache->remember($id . '_getBrandnames', 900, function () use ($attributes) {
            return $this->model->where('partner_id', $attributes["partner_id"])->get();
        });

        return $brandnames;
    }
}
