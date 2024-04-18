<?php

namespace App\Repositories\Contracts;

use App\DTOs\RegisterDTO;
use App\Models\User;

interface UsersRepositoryInterface
{
    public function create(RegisterDTO $data): User;
    public function findByEmail(string $email): User|null;
}
