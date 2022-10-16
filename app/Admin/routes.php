<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => ($middleware = config('admin.route.middleware')),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) use ($middleware) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('users', UserController::class);
    $router->resource('locations', LocationController::class);
    $router->get('api/locations/without-user', 'PostController@indexLocationsWithoutUser')
        ->name('api.locations.index.without-user')
        ->withoutMiddleware($middleware);
    $router->resource('location-scores', LocationScoreController::class);
    $router->resource('posts', PostController::class);
    $router->get('api/city-areas/belong-to-city', 'LocationController@indexCityAreasBelongToCity')
        ->name('api.city-areas.index.belong-to-city')
        ->withoutMiddleware($middleware);
    $router->resource('comments', CommentController::class);
    $router->resource('cities', CityController::class);
});
