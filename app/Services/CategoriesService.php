<?php

namespace App\Services;

use App\Domain\CategoryEntity;
use App\DTOs\CreateCategoryDTO;
use App\DTOs\SearchCategoriesDTO;
use App\DTOs\UpdateCategoryDTO;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use App\Repositories\Contracts\CategoriesRepositoryInterface;
use App\Repositories\Contracts\PaginationInterface;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoriesService
{
    public function __construct(
        protected CategoriesRepositoryInterface $categoriesRepository
    ) {}

    public function findAll(SearchCategoriesDTO $search): PaginationInterface
    {
        Log::info("CategoriesService::findAll");

        return $this->categoriesRepository->search($search);
    }

    /**
     * @throws BadRequestException
     */
    public function create(CreateCategoryDTO $data): Category
    {
        Log::info("CategoriesService::create");

        $foundCategory = $this->categoriesRepository->findByName($data->name);

        if ($foundCategory) {
            throw new BadRequestException("Categoria com o nome $data->name já existe.");
        }

        $category = new CategoryEntity($data->user_id, $data->name);

        return $this->categoriesRepository->create($category);
    }

    /**
     * @throws NotFoundException
     */
    public function findById(string $id): Category
    {
        Log::info("CategoriesService::findById");

        $category = $this->categoriesRepository->findById($id);

        if (!$category) {
            throw new NotFoundException("Categoria com o id $id não encontrada.");
        }

        return $category;
    }

    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function update(UpdateCategoryDTO $data): Category
    {
        Log::info("CategoriesService::update");

        $foundCategory = $this->categoriesRepository->findById($data->id);

        if (!$foundCategory) {
            throw new NotFoundException("Categoria com o id $data->id não encontrada.");
        }

        if ($foundCategory->user_id !== $data->user_id) {
            throw new BadRequestException('Operação inválida.');
        }

        $category = new CategoryEntity(
            $data->user_id,
            $data->name,
            $data->id,
            $foundCategory->created_at,
            new DateTime()
        );

        return $this->categoriesRepository->update($category);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(string $id): void
    {
        Log::info("CategoriesService::delete");

        $category = $this->categoriesRepository->findById($id);

        if (!$category) {
            throw new NotFoundException("Categoria com o id $id não encontrada.");
        }

        $this->categoriesRepository->delete($id);
    }
}
