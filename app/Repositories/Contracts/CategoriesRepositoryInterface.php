<?php

namespace App\Repositories\Contracts;

use App\Domain\CategoryEntity;
use App\DTOs\SearchCategoriesDTO;
use App\Models\Category;

interface CategoriesRepositoryInterface
{
    public function search(SearchCategoriesDTO $search): PaginationInterface;
    public function create(CategoryEntity $category): Category;
    public function findById(string $id): ?Category;
    public function findByName(string $name): ?Category;
    public function update(CategoryEntity $category): Category;
    public function delete(string $id): void;
}
