<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Exceptions\IncorrectEmailOrPassword;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Requests\RegisterFormRequest;
use App\Requests\LoginFormRequest;
use App\Services\AuthService;
use App\Services\UsersService;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {

    }

    public function register(RegisterFormRequest $request)
    {
        $user = $this->authService->register(RegisterDTO::makeFromRequest($request));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @throws IncorrectEmailOrPassword
     */
    public function login(LoginFormRequest $request)
    {
        $login = $this->authService->login(LoginDTO::makeFromRequest($request));

        return (new LoginResource($login))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
