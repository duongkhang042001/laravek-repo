<?php

namespace App\Abstracts\Repository;

interface IBrandnameRepository
{
    function model();

    public function getAllWithCache($id, $attributes);
}
