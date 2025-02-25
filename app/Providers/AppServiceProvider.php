<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    public function boot()
    {
        //
    }
}
