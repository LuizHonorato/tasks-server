<?php

namespace App\Services;

use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateTaskDTO;
use App\Exceptions\NotAuthorizedOperation;
use App\Exceptions\TaskNotFound;
use App\Repositories\Contracts\TasksRepositoryInterface;
use stdClass;

class TasksService
{
    public function __construct(
        protected TasksRepositoryInterface $tasksRepository
    ) {}

    public function findAll(SearchTasksDTO $query)
    {
        return $this->tasksRepository->search($query);
    }

    public function create(CreateTaskDTO $payload): stdClass
    {
        return $this->tasksRepository->create($payload);
    }

    /**
     * @throws TaskNotFound
     * @throws NotAuthorizedOperation
     */
    public function findById(int $user_id, int $id): stdClass
    {
        $task = $this->tasksRepository->findById($id);

        if (!$task) {
            throw new TaskNotFound();
        }

        if ($task->user_id != $user_id) {
            throw new NotAuthorizedOperation();
        }

        return $task;
    }

    /**
     * @throws NotAuthorizedOperation
     * @throws TaskNotFound
     */
    public function update(UpdateTaskDTO $payload): stdClass
    {
        $task = $this->tasksRepository->findById($payload->id);

        if (!$task) {
            throw new TaskNotFound();
        }

        if ($task->user_id != $payload->user_id) {
            throw new NotAuthorizedOperation();
        }

        return $this->tasksRepository->update($payload);
    }

    /**
     * @throws TaskNotFound
     */
    public function delete($id): void
    {
        $task = $this->tasksRepository->findById($id);

        if (!$task) {
            throw new TaskNotFound();
        }

        $this->tasksRepository->delete($id);
    }
}
