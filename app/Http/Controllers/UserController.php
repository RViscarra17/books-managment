<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResponse;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        return response(new UserResponse($user), Response::HTTP_CREATED);
    }
}
