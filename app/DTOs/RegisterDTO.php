<?php

namespace App\DTOs;

use App\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    public static function makeFromRequest(RegisterFormRequest $request): self
    {
        return new self(
            $request['name'],
            $request['email'],
            Hash::make($request['password'])
        );
    }
}
