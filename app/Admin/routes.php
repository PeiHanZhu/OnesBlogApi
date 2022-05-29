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
    $router->resource('posts', PostController::class);
    $router->get('stores/without_user', 'PostController@indexStoresWithoutUser')
        ->name('stores.without.user')
        ->withoutMiddleware($middleware);
    $router->resource('comments', CommentController::class);
});
