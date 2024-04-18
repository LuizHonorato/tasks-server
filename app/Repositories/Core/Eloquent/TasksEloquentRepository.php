<?php

namespace App\Repositories\Core\Eloquent;

use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\TasksRepositoryInterface;
use App\Repositories\Core\PaginationPresenter;
use stdClass;

class TasksEloquentRepository implements TasksRepositoryInterface
{
    public function __construct(
        protected Task $entity
    ) {}

    public function search(SearchTasksDTO $data): PaginationInterface
    {
        $result = $this->entity
                ->where(function ($query) use ($data) {
                    if (isset($data->name)) {
                        $query->where('name', 'LIKE', "%{$data->name}%");
                    }
                })
                ->where('user_id', $data->user_id)
                ->orderBy($data->column, $data->order)
                ->paginate($data->per_page);

        return new PaginationPresenter($result);
    }

    public function create(CreateTaskDTO $payload): stdClass
    {
        $task = $this->entity->create(
            (array) $payload
        );

        return (object) $task->toArray();
    }

    public function findById(int $id): stdClass|null
    {
        $task = $this->entity->find($id);
        if (!$task) {
            return null;
        }

        return (object) $task->toArray();
    }

    public function update(UpdateTaskDTO $payload): stdClass|null
    {
        if (!$task = $this->entity->find($payload->id)) {
            return null;
        }

        $task->update(
            (array) $payload
        );

        return (object) $task->toArray();
    }

    public function delete(int $id): void
    {
        $task = $this->entity->findOrFail($id);
        $task->delete();
    }
}
