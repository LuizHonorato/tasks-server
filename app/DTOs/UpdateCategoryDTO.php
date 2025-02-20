<?php

namespace App\DTOs;

use App\Http\Requests\CreateUpdateCategoryFormRequest;

class UpdateCategoryDTO
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $name,
    ) {}

    public static function makeFromRequest(CreateUpdateCategoryFormRequest $request): self
    {
        return new self(
            $request['id'],
            $request['user_id'],
            $request['name'],
        );
    }
}
