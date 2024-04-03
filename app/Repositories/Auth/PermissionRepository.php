<?php

namespace App\Repositories\Auth;

use App\Abstracts\Repository\BaseRepository;
use App\Models\Auth\Permission as Model;

class PermissionRepository extends BaseRepository
{
    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        return $this->model->get();
    }

    public function create($attributes)
    {
    }

    public function find($id)
    {
    }

    public function update($id, $attributes)
    {
    }

    public function delete($id)
    {
    }
}
