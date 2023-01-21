<?php

namespace App\Providers;

use App\Packages\Cart\Domain\CartFactoryInterface;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\ProductFactoryInterface;
use App\Packages\Cart\Infrastructure\CartFactory;
use App\Packages\Cart\Infrastructure\CartRepository;
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

        $this->app->singleton(CartRepositoryInterface::class, CartRepository::class);
        $this->app->singleton(CartFactoryInterface::class, CartFactory::class);
        $this->app->singleton(ProductFactoryInterface::class, ProductFactory::class);
        
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
