<?php

namespace App\DTOs;

use App\Http\Requests\CreateUpdateTaskFormRequest;

class CreateTaskDTO
{
    public function __construct(
        public string $user_id,
        public string $category_id,
        public string $title,
        public string|null $description,
        public string|null $status
    ) {}

    public static function makeFromRequest(CreateUpdateTaskFormRequest $request): self
    {
        return new self(
            $request->user()->id ?? '052402bf-4d5a-49c9-bfbc-2e29b14252df',
            $request['category_id'],
            $request['title'],
            $request['description'],
            $request['status']
        );
    }
}
