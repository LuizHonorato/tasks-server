<?php

namespace App\Repositories\Core\Eloquent;

use App\Domain\CategoryEntity;
use App\Models\Category;
use App\DTOs\SearchCategoriesDTO;
use App\Repositories\Contracts\CategoriesRepositoryInterface;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Core\PaginationPresenter;
use Illuminate\Support\Facades\Log;

class CategoriesEloquentRepository implements CategoriesRepositoryInterface
{
    public function __construct(
        protected Category $entity
    ) {}

    public function search(SearchCategoriesDTO $search): PaginationInterface
    {
        Log::info("CategoriesEloquentRepository::search");

        $result = $this->entity
            ->where(function ($query) use ($search) {
                if (isset($search->name)) {
                    $query->where('name', 'LIKE', "%{$search->name}%");
                }
            })
            ->where('user_id', $search->user_id)
            ->orderBy($search->column, $search->order)
            ->paginate($search->per_page);

        return new PaginationPresenter($result);
    }

    public function create(CategoryEntity $category): Category
    {
        Log::info("CategoriesEloquentRepository::create");

        return $this->entity->create([
            'id' => $category->getId(),
            'user_id' => $category->getUserId(),
            'name' => $category->getName(),
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt()
        ]);
    }

    public function findById(string $id): ?Category
    {
        Log::info("CategoriesEloquentRepository::findById");

        $category = $this->entity->find($id);

        if (!$category) {
            return null;
        }

        return $category;
    }

    public function findByName(string $name): ?Category
    {
        Log::info("CategoriesEloquentRepository::findByName");

        $category = $this->entity->where('name', $name)->first();

        if (is_null($category)) {
            return null;
        }

        return $category;
    }

    public function update(CategoryEntity $entity): Category
    {
        Log::info("CategoriesEloquentRepository::update");

        $category = $this->entity->where('id', $entity->getId())->first();

        $category->update([
            'id' => $entity->getId(),
            'user_id' => $entity->getUserId(),
            'name' => $entity->getName(),
            'updated_at' => $entity->getUpdatedAt()
        ]);

        return $category;
    }

    public function delete(string $id): void
    {
        Log::info("CategoriesEloquentRepository::delete");

        $category = $this->entity->findOrFail($id);
        $category->delete();
    }
}
