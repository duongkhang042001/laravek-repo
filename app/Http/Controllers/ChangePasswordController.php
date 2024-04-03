<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use App\Abstracts\Http\Controllers\ApiController;
use App\Http\Requests\Auth\ChangePasswordRequest as Request;

class ChangePasswordController extends ApiController
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        User::findOrFail($request->get('user_id'))->update(['password' => $request->get('new_password')]);

        return $this->response->array([
            'success' => true
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
