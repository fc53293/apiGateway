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


$router->get('/', function (){
    return view('login');
});


Route::get('/signin', 'apiGatewayController@showSigninPage');

Route::get('/login', 'apiGatewayController@showCurrentUser');

Route::get('/signup', 'apiGatewayController@showSignupPage');




Route::get('home', 'apiGatewayController@showHome');

Route::get('payment', 'apiGatewayController@showPayment');

Route::get('inquilinoProfile/{id}', 'apiGatewayController@showInquilinoProfile');

Route::post('edit/{id}', 'apiGatewayController@updateInquilinoProfile');

