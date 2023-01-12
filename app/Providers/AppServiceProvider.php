<?php

namespace App\Providers;

use App\Packages\User\Domain\UserFactoryInterface;
use App\Packages\User\Domain\UserRepositoryInterface;
use App\Packages\User\Infrastructure\UserFactory;
use App\Packages\User\Infrastructure\UserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(UserFactoryInterface::class, UserFactory::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        JsonResource::withoutWrapping();
    }
}
