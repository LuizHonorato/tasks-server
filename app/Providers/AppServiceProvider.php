<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Repositories\Contracts\CategoriesRepositoryInterface;
use App\Repositories\Contracts\TasksRepositoryInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Core\Eloquent\CategoriesEloquentRepository;
use App\Repositories\Core\Eloquent\TasksEloquentRepository;
use App\Repositories\Core\Eloquent\UsersEloquentRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsersRepositoryInterface::class, UsersEloquentRepository::class);
        $this->app->bind(CategoriesRepositoryInterface::class, CategoriesEloquentRepository::class);
        $this->app->bind(TasksRepositoryInterface::class, TasksEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
