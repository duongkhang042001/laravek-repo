<?php

namespace App\Abstracts\Http\Controllers;

use App\Http\Requests\Quota\IndexRequest;
use App\Http\Requests\Quota\UpdateRequest;

interface IQuotaController
{
    public function index(IndexRequest $param);

    public function show(int $id);

    public function update(UpdateRequest $request, int $id);
}
