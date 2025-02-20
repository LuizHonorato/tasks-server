<?php

namespace App\Repositories\Contracts;

use App\Domain\TaskEntity;
use App\DTOs\SearchTasksDTO;
use App\Models\Task;

interface TasksRepositoryInterface
{
    public function search(SearchTasksDTO $search): PaginationInterface;
    public function create(TaskEntity $task): Task;
    public function findById(string $id): ?Task;
    public function findByTitle(string $title): ?Task;
    public function update(TaskEntity $entity): Task;
    public function delete(string $id): void;
}
