<?php

namespace App\Abstracts\Http\Controllers;

use App\Http\Requests\Plan\IndexRequest;
use App\Http\Requests\Plan\UpdateRequest;

interface IPlanController
{
    public function index(IndexRequest $param);

    public function show(int $id);

    public function update(UpdateRequest $request, int $id);
}
