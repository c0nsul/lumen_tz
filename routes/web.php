<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use App\Http\Controllers\CurrencyController;

$router->get('/', 'CurrencyController@index');
$router->get('/currencies', 'CurrencyController@index');
$router->get('/currencies/{id}', 'CurrencyController@show');
