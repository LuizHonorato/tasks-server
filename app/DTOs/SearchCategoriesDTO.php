<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class SearchCategoriesDTO
{
    public function __construct(
        public string $user_id,
        public string|null $name,
        public string $column,
        public string $order,
        public int $per_page,
    ) {}

    public static function makeFromRequest(Request $request): self
    {
        return new self(
            $request->user()->id,
            $request['name'] ?? null,
            $request['column'] ?? 'created_at',
            $request['order'] ?? 'desc',
            intval($request['per_page']) ?? 10,
        );
    }
}
