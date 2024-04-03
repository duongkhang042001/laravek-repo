<?php

namespace App\Abstracts\Repository;

interface IPlanRepository
{
    function model();

    public  function all($filter = []);

    public function find($id);

    public function update($attributes, $id);
}
