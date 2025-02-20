<?php

namespace App\DTOs;

use App\Http\Requests\CreateUpdateTaskFormRequest;

class UpdateTaskDTO
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $category_id,
        public string $title,
        public string|null $description,
        public string|null $status
    ) {}

    public static function makeFromRequest(CreateUpdateTaskFormRequest $request): self
    {
        return new self(
            $request['id'],
            $request->user()->id,
            $request['category_id'],
            $request['title'],
            $request['description'],
            $request['status']
        );
    }
}
