<?php

namespace App\Abstracts\Repository;

interface IRepository
{
    function model();

    public function all($filter = []);

    public function create($attributes);

    public function find($id);

    public function update($id, $attributes);

    public function delete($id);
}
