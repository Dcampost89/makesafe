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

$router->group(['prefix' => 'user'], function($router) {
    $router->post('signin', 'UserController@signin');
    $router->post('current', 'UserController@currentUser');
    $router->post('signup', 'UserController@signup');
    $router->post('signoff', 'UserController@signoff');
});