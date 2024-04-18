<?php

namespace App\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Exceptions\IncorrectEmailOrPassword;
use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected UsersRepositoryInterface $usersRepository
    ) {}

    public function register(RegisterDTO $data)
    {
        return $this->usersRepository->create($data);
    }

    /**
     * @throws IncorrectEmailOrPassword
     */
    public function login(LoginDTO $data): array
    {
        $user = $this->findByEmail($data->email);

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw new IncorrectEmailOrPassword();
        }

        return [
            'user' => $user,
            'access_token' => $user->createToken('__tasks_auth_token')->plainTextToken
        ];
    }

    public function findByEmail($email): User|null
    {
        return $this->usersRepository->findByEmail($email);
    }
}
