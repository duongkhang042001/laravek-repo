<?php

namespace App\Repositories\Auth;

use App\Models\Auth\User;
use App\Models\Auth\User as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Abstracts\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container as Application;
use App\Repositories\Brandname\BrandnameRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class AccountRepository extends BaseRepository
{
    private $filterFields = ['created_at', 'updated_at'];

    protected $brandnameRepository;

    protected $permissionRepository;

    public function __construct(
        Application $app,
        CacheRepository $cache,
        BrandnameRepository $brandnameRepository,

    ) {
        parent::__construct($app, $cache);

        $this->brandnameRepository = $brandnameRepository;
    }

    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        $perPage = isset($filter['pageSize']) && !empty($filter['pageSize']) ? $filter['pageSize'] : 9;

        $page = Paginator::resolveCurrentPage('current');

        $qb = $this->model->select(['id', 'partner_id', 'username', 'full_name', 'phone_number', 'email', 'is_admin', 'enabled', 'created_by', 'updated_by', 'created_at', 'updated_at']);

        if (isset($filter['q'])) {
            $qb->where(function ($q) use ($filter) {
                $q->where('username', 'LIKE', $filter['q'] . '%')
                    ->orWhere('full_name', 'LIKE', $filter['q'] . '%')
                    ->orWhere('phone_number', 'LIKE', $filter['q'] . '%');
            });
        }

        if (isset($filter['from']) && isset($filter['to'])) {
            $qb->where(function ($q) use ($filter) {
                $q->where('created_at', '>=', $filter['from'])
                    ->where('created_at', '<', date('Y-m-d', strtotime($filter['to'] . ' +1 day')));
            });
        }

        if (isset($filter['enabled'])) {
            $qb->where('enabled', $filter['enabled']);
        }

        if (!empty($filter['is_admin'])) {
            $qb->where('is_admin', $filter['is_admin']);
        }

        $defaultSortField = isset($filter['sort']) ? $filter['sort'] :  'created_at';
        $defaultSortOrder = isset($filter['order']) ? $filter['order'] :  'descend';

        $qb->orderBy($defaultSortField, core()->parseOrder($defaultSortOrder));

        $countQuery = "select count(*) as aggregate from ({$qb->toSql()}) c";
        $count = collect(DB::select($countQuery, $qb->getBindings()))->pluck('aggregate')->first();

        if ($count > 0) {
            $items = $qb->forPage($page, $perPage)->with(['brandnames:id,name', 'permissions:name', 'creator', 'editor'])->get();
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

        // Transaction
        DB::beginTransaction();

        // Create
        $model = $this->model->create($attributes);

        // Assign brandnames
        $brandnames = $this->brandnameRepository->getAllWithCache($model->id, $attributes)->whereIn('id', $attributes['brandnames'])->pluck('id')->all();
        $model->brandnames()->attach($brandnames);

        // Assign permissions
        $permissions = $model->partner->getAllPermissions()->all();
        $model->givePermissionTo($permissions);

        DB::commit();

        $this->resetModel();

        return $model;
    }

    public function find($id)
    {
        $model = $this->model->with(['brandnames:id,name', 'permissions:name', 'partner', 'creator', 'editor'])->findOrFail($id);
        $this->resetModel();

        return $model;
    }

    public function update($id, $attributes)
    {
        $model = $this->model->findOrFail($id);

        // Transaction
        DB::beginTransaction();

        // Update
        $model->fill([
            ...$attributes,
            'updated_by' => null
        ]);

        $model->save();
        // Assign brandnames
        if (isset($attributes['brandnames'])) {
            $brandnames = $this->brandnameRepository->getAllWithCache($model->id, $attributes)->whereIn('id', $attributes['brandnames'])->pluck('id')->all();

            $model->brandnames()->sync($brandnames);

            $this->cache->forget($model->id . '_getBrandnames');
        }

        // Assign permissions
        if (isset($attributes['permissions'])) {
            $permissions = $model->partner->getAllPermissions()->whereIn('name', $attributes['permissions'])->all();

            $model->syncPermissions($permissions);
        }

        // Commit
        DB::commit();

        $this->resetModel();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        $this->resetModel();

        $model->delete();

        $this->resetModel();

        return $model;
    }
}
