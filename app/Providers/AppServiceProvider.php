<?php

namespace App\Providers;

use App\Repositories\V1\TaskRepository;
use App\Repositories\V1\TaskRepositoryInterface;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\UserRepositoryInterface;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }
}
