<?php

namespace App\Services;

use App\Domain\CategoryEntity;
use App\Domain\TaskEntity;
use App\Domain\TaskStatusEnum;
use App\DTOs\CreateCategoryDTO;
use App\DTOs\CreateTaskDTO;
use App\DTOs\SearchCategoriesDTO;
use App\DTOs\SearchTasksDTO;
use App\DTOs\UpdateCategoryDTO;
use App\DTOs\UpdateTaskDTO;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use App\Models\Task;
use App\Repositories\Contracts\CategoriesRepositoryInterface;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\TasksRepositoryInterface;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class TasksService
{
    public function __construct(
        protected TasksRepositoryInterface $tasksRepository,
        protected CategoriesRepositoryInterface $categoriesRepository,
    ) {}

    public function findAll(SearchTasksDTO $search): PaginationInterface
    {
        Log::info("TasksService::findAll");

        return $this->tasksRepository->search($search);
    }

    /**
     * @throws BadRequestException|NotFoundException
     */
    public function create(CreateTaskDTO $data): Task
    {
        Log::info("TasksService::create");

        $foundTask = $this->tasksRepository->findByTitle($data->title);

        if ($foundTask) {
            throw new BadRequestException("Tarefa com o nome $data->title já existe.");
        }

        $category = $this->categoriesRepository->findById($data->category_id);

        if (is_null($category)) {
            throw new NotFoundException("Categoria com o id $data->category_id não foi encontrada");
        }

        if ($category->user_id !== $data->user_id) {
            throw new BadRequestException("Operação inválida.");
        }

        $task = new TaskEntity(
            $data->user_id,
            $data->category_id,
            $data->title,
            $data->description,
            null,
            TaskStatusEnum::from($data->status) ?? null
        );

        return $this->tasksRepository->create($task);
    }

    /**
     * @throws NotFoundException
     */
    public function findById(string $id): Task
    {
        Log::info("TasksService::findById");

        $task = $this->tasksRepository->findById($id);

        if (!$task) {
            throw new NotFoundException("Tarefa com o id $id não encontrada.");
        }

        return $task;
    }

    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function update(UpdateTaskDTO $data): Task
    {
        Log::info("TasksService::update");

        $foundTask = $this->tasksRepository->findById($data->id);

        if (!$foundTask) {
            throw new NotFoundException("Tarefa com o id $data->id não encontrada.");
        }

        if ($foundTask->user_id !== $data->user_id) {
            throw new BadRequestException('Operação inválida.');
        }

        $category = $this->categoriesRepository->findById($data->category_id);

        if (is_null($category)) {
            throw new NotFoundException("Categoria com o id $data->category_id não foi encontrada");
        }

        if ($category->user_id !== $data->user_id) {
            throw new BadRequestException("Operação inválida.");
        }

        $task = new TaskEntity(
            $data->user_id,
            $data->category_id,
            $data->title,
            $data->description,
            $data->id,
            TaskStatusEnum::from($data->status) ?? null,
            $foundTask->created_at,
            new DateTime()
        );

        return $this->tasksRepository->update($task);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(string $id): void
    {
        Log::info("TasksService::delete");

        $task = $this->tasksRepository->findById($id);

        if (!$task) {
            throw new NotFoundException("Categoria com o id $id não encontrada.");
        }

        $this->tasksRepository->delete($id);
    }
}
