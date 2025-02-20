<?php

namespace App\DTOs;

use App\Http\Requests\CreateUpdateCategoryFormRequest;

class CreateCategoryDTO
{
    public function __construct(
        public string $user_id,
        public string $name,
    ) {}

    public static function makeFromRequest(CreateUpdateCategoryFormRequest $request): self
    {
        return new self(
            $request['user_id'],
            $request['name'],
        );
    }
}
