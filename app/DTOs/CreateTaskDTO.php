<?php

namespace App\DTOs;

use App\Requests\CreateUpdateTaskFormRequest;
use Carbon\Carbon;
use DateTime;

class CreateTaskDTO
{
    public function __construct(
        public int $user_id,
        public string $name,
        public string|null $description,
        public DateTime|null $delivered_at
    ) {}

    public static function makeFromRequest(CreateUpdateTaskFormRequest $request): self
    {
        return new self(
            $request->user()->id,
            $request['name'],
            $request['description'] ?? null,
            $request['completed'] ? Carbon::now() : null
        );
    }
}
