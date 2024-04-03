<?php

namespace App\Abstracts\Repository;

interface IBrandnameConfigRepository
{
    function model();

    public function all($id);

    public function getDefaults();

    public function bulkUpdate(array $inputs = [], $id);
}
