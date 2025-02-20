<?php

namespace App\DTOs;

use App\Http\Requests\LoginFormRequest;

class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}

    public static function makeFromRequest(LoginFormRequest $request): self
    {
        return new self(
            $request['email'],
            $request['password']
        );
    }
}
