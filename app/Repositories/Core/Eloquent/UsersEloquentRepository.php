<?php

namespace App\Repositories\Core\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;

class UsersEloquentRepository implements UsersRepositoryInterface
{
    public function __construct(
        protected User $entity
    ) {}

    public function findByEmail(string $email): User|null
    {
        return $this->entity->where('email', $email)->first();
    }
}
