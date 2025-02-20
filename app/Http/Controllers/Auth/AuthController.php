<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Resources\LoginResource;
use App\Services\AuthService;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginFormRequest $request)
    {
        $login = $this->authService->login(LoginDTO::makeFromRequest($request));

        return (new LoginResource($login))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
