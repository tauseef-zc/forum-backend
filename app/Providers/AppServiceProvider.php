<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Services\AuthService;
use App\Services\CommentService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        AuthServiceInterface::class => AuthService::class,
        AuthRepositoryInterface::class => AuthRepository::class,
        PostServiceInterface::class => PostService::class,
        PostRepositoryInterface::class => PostRepository::class,
        CommentServiceInterface::class => CommentService::class,
        CommentRepositoryInterface::class => CommentRepository::class
    ];

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
        //
    }
}
