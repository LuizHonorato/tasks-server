<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class SearchTasksDTO
{
    public function __construct(
        public string $user_id,
        public string|null $title,
        public string|null $category_id,
        public string|null $status,
        public string $column,
        public string $order,
        public int $per_page
    ) {}

    public static function makeFromRequest(Request $request): self
    {
        return new self(
            $request->user()->id ?? '052402bf-4d5a-49c9-bfbc-2e29b14252df',
            $request['title'] ?? null,
            $request['category_id'] ?? null,
            $request['status'] ?? null,
            $request['column'] ?? 'created_at',
            $request['order'] ?? 'desc',
            intval($request['per_page']) ?? 10
        );
    }
}
