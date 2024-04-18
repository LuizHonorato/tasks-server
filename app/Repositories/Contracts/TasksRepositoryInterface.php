<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateTaskDTO;
use stdClass;

interface TasksRepositoryInterface
{
    public function search(SearchTasksDTO $data): PaginationInterface;
    public function create(CreateTaskDTO $payload): stdClass;
    public function findById(int $id): stdClass|null;
    public function update(UpdateTaskDTO $payload): stdClass|null;
    public function delete(int $id): void;
}
