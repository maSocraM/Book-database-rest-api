<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Publishers
$router->group(['prefix' => 'publishers'], function () use ($router) {
    $router->get('list', 'PublishersController@getAll');
    $router->get('list/{offset}/{limit}', 'PublishersController@getAll');
    $router->get('/{id}', 'PublishersController@getOne');
    $router->post('', 'PublishersController@insert');
    $router->put('/{id}', 'PublishersController@update');
    $router->delete('/{id}', 'PublishersController@delete');
});

// Authors
$router->group(['prefix' => 'authors'], function () use ($router) {
    $router->get('list', 'AuthorsController@getAll');
    $router->get('list/{offset}/{limit}', 'AuthorsController@getAll');
    $router->get('/{id}', 'AuthorsController@getOne');
    $router->post('', 'AuthorsController@insert');
    $router->put('/{id}', 'AuthorsController@update');
    $router->delete('/{id}', 'AuthorsController@delete');
});

// Books
$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('highlighted', 'BooksController@getAll');
    $router->get('highlighted/{offset}/{limit}', 'BooksController@getAll');
    $router->get('search[/{term}]', 'BooksController@getSearch');
    $router->get('search/{term}/{offset}/{limit}', 'BooksController@getSearch');
    $router->get('{id}', 'BooksController@getOne');
    $router->post('', 'BooksController@insert');
    $router->put('/{id}', 'BooksController@update');
    $router->delete('/{id}', 'BooksController@delete');
});
