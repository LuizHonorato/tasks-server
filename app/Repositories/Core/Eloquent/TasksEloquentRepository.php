<?php

namespace App\Repositories\Core\Eloquent;

use App\Domain\TaskEntity;
use App\DTOs\SearchTasksDTO;
use App\Models\Task;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\TasksRepositoryInterface;
use App\Repositories\Core\PaginationPresenter;
use Illuminate\Support\Facades\Log;

class TasksEloquentRepository implements TasksRepositoryInterface
{
    public function __construct(
        protected Task $entity
    ) {}

    public function search(SearchTasksDTO $search): PaginationInterface
    {
        Log::info("TasksEloquentRepository::search");

        $query = $this->entity
            ->where(function ($query) use ($search) {
                if (isset($search->title)) {
                    $query->where('title', 'LIKE', "%{$search->title}%");
                }
            })
            ->where('user_id', $search->user_id)
            ->orderBy($search->column, $search->order)
            ->with('category');

        if ($search->category_id) {
            $query->where('category_id', $search->category_id);
        }

        if ($search->status) {
            $query->where('status', $search->status);
        }

        $result = $query->paginate($search->per_page);

        return new PaginationPresenter($result);
    }

    public function create(TaskEntity $task): Task
    {
        Log::info("TasksEloquentRepository::create");

        return $this->entity->create([
            'id' => $task->getId(),
            'user_id' => $task->getUserId(),
            'category_id' => $task->getCategoryId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'created_at' => $task->getCreatedAt(),
            'updated_at' => $task->getUpdatedAt()
        ]);
    }

    public function findById(string $id): ?Task
    {
        Log::info("TasksEloquentRepository::findById");

        $task = $this->entity->find($id);

        if (is_null($task)) {
            return null;
        }

        return $task;
    }

    public function findByTitle(string $title): ?Task
    {
        Log::info("TasksEloquentRepository::findByTitle");

        $task = $this->entity->where('title', $title)->first();

        if (is_null($task)) {
            return null;
        }

        return $task;
    }

    public function update(TaskEntity $entity): Task
    {
        Log::info("TasksEloquentRepository::update");

        $task = $this->entity->where('id', $entity->getId())->first();

        $task->update([
            'id' => $entity->getId(),
            'user_id' => $entity->getUserId(),
            'category_id' => $entity->getCategoryId(),
            'title' => $entity->getTitle(),
            'description' => $entity->getDescription(),
            'status' => $entity->getStatus(),
            'updated_at' => $entity->getUpdatedAt()
        ]);

        return $task;
    }

    public function delete(string $id): void
    {
        Log::info("TasksEloquentRepository::delete");

        $task = $this->entity->findOrFail($id);
        $task->delete();
    }
}
