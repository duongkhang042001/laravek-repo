<?php

namespace App\Http\Controllers;


use App\Models\Auth\User;
use App\Repositories\Auth\AccountRepository;
use App\Http\Requests\Auth\AccountIndexRequest;
use App\Abstracts\Http\Controllers\ApiController;
use App\Http\Requests\Auth\AccountRequest as Request;
use App\Http\Resources\Auth\Account as AccountResource;
use App\Http\Resources\Auth\Accounts as AccountCollection;

class AccountController extends ApiController
{
    private $repository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->repository = $accountRepository;
    }

    public function index(AccountIndexRequest $request)
    {
        return new AccountCollection($this->repository->all($request->validated()));
    }

    public function store(Request $request)
    {
        $account = $this->repository->create($request->validated());
        return $this->response->array([
            'success' => true,
            'data' => [
                'id' => $account->id
            ]
        ]);
    }

    public function show(string $id)
    {
        return $this->response->array([
            'success' => true,
            'data' => new AccountResource($this->repository->find($id))
        ]);
    }

    public function update(Request $request, string $id)
    {
        $account = $this->repository->update($id, $request->validated());

        return $this->response->array([
            'success' => true,
            'data' => [
                'id' => $account->id
            ]
        ]);
    }

    public function destroy(string $id)
    {
        $this->repository->delete($id);

        return $this->response->array(['success' => true]);
    }
}
