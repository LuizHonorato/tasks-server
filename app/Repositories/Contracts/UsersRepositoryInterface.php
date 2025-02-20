<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UsersRepositoryInterface
{
    public function findByEmail(string $email): User|null;
}
