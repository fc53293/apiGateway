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

//use Illuminate\Support\Facades\Route;

Route::get('/healthz', function () {
    return 'ok';
});

$router->get('/', function (){
    return view('login');
});


$router->group(['prefix' => 'api'], function($router)
{
    $router->post('artigo/add','apiGatewayController@createArtigo');
    $router->get('artigo/all','apiGatewayController@allArtigos');
    
}); 

Route::get('/signin', 'apiGatewayController@showSigninPage');

Route::get('/entra', 'apiGatewayController@entra');

Route::get('/signup', 'apiGatewayController@showSignupPage');

Route::get('signin2', 'apiGatewayController@mostraArtigos');
