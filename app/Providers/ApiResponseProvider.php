<?php

namespace App\Providers;

use App\Builders\ApiResponseBuilder;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Register custom responses for API
         * */
        Response::macro('custom', [ApiResponseBuilder::class, 'customResponse']);
        Response::macro('ok', [ApiResponseBuilder::class, 'okResponse']);
        Response::macro('collection', [ApiResponseBuilder::class, 'collectionResponse']);
        Response::macro('badRequest', [ApiResponseBuilder::class, 'badRequestResponse']);
        Response::macro('unauthorized', [ApiResponseBuilder::class, 'unauthorizedResponse']);
        Response::macro('notFound', [ApiResponseBuilder::class, 'notFoundResponse']);
        Response::macro('error', [ApiResponseBuilder::class, 'errorResponse']);
    }
}
