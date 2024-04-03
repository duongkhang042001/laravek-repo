<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\ExportRequest;
use App\Abstracts\Http\Controllers\ApiController;
use App\Repositories\Brandname\MessageRepository;
use App\Http\Requests\Message\MessageIndexRequest;
use App\Http\Resources\Brandname\Messages as MessageCollection;

class MessageController extends ApiController
{
    private $repository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->repository = $messageRepository;
    }

    public function index(MessageIndexRequest $param)
    {
        return new MessageCollection($this->repository->all($param->validated()));
    }

    public function export(ExportRequest $request)
    {
        //
    }
}
