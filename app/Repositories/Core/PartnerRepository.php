<?php

namespace App\Repositories\Core;

use App\Models\Auth\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Core\Partner as Model;
use App\Abstracts\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerRepository extends BaseRepository
{
    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        $perPage = isset($filter['pageSize']) && !empty($filter['pageSize']) ? $filter['pageSize'] : 9;

        $page = Paginator::resolveCurrentPage('current');

        $qb = $this->model->select(['id', 'name', 'enabled', 'created_at', 'updated_at']);

        if (!empty($filter['name'])) {
            $qb->where('name', 'like', $filter['name'] . '%');
        }

        if (isset($filter['enabled'])) {
            $qb->where('enabled', $filter['enabled']);
        }

        if (isset($filter['order']) && isset($filter['sort'])) {
            $qb->orderBy($filter['order'], $filter['sort']);
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

    public function create($attributes)
    {
        DB::beginTransaction();

        $model = $this->model->create($attributes);

        $model->brandnames()->attach($attributes['brandname_ids']);

        if (isset($attributes['roles']) && is_array($attributes['roles'])) {
            $validRoles = Role::whereIn('id', $attributes['roles'])->pluck('id')->toArray();

            if (count($attributes['roles']) !== count($validRoles)) {
                DB::rollBack();
                abort(400, "Can't create Partner! Some roles selected do not exist.");
            }

            $model->roles()->attach($validRoles);
        }

        DB::commit();

        $this->resetModel();

        return $model;
    }

    public function find($id)
    {
        $model = $this->model->with(['roles:id,name'])->findOrFail($id);

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
}
