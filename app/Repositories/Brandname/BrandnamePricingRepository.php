<?php

namespace App\Repositories\Brandname;

use App\Abstracts\Repository\BaseRepository;
use App\Models\Brandname\BrandnamePricing as Model;

class BrandnamePricingRepository extends BaseRepository
{
    function model()
    {
        return Model::class;
    }

    public function all($filter = [])
    {
        //
    }

    public function create($attributes)
    {
        //
    }

    public function find($id)
    {
        $model = $this->model->where("brandname_id", $id)->get()->toArray();
        return $model;
    }

    public function update($id, $attributes)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
