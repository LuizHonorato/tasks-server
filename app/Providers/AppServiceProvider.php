<?php

namespace App\Providers;

use App\Repositories\Contracts\TasksRepositoryInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Core\Eloquent\TasksEloquentRepository;
use App\Repositories\Core\Eloquent\UsersEloquentRepository;
use App\Services\AuthService;
use App\Services\TasksService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersRepositoryInterface::class, UsersEloquentRepository::class);
        $this->app->bind(TasksRepositoryInterface::class, TasksEloquentRepository::class);
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService($app->make(UsersRepositoryInterface::class));
        });
        $this->app->bind(TasksService::class, function ($app) {
            return new TasksService($app->make(TasksRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
