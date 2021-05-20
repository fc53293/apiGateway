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

Route::get('registerSenhorio', 'apiGatewayController@showSignupSenhorio');

Route::get('inquilinoProfile/{id}', 'apiGatewayController@showInquilinoProfile');

Route::post('edit/{id}', 'apiGatewayController@updateInquilinoProfile');

Route::post('/createUser', 'apiGatewayController@createNewUser');

Route::post('/createSenhorio', 'apiGatewayController@createNewSenhorio');
Route::post('renovar/{id}', 'apiGatewayController@renovarAluguerInquilino');

Route::get('payment', 'apiGatewayController@showPayments');

Route::get('wallet/{id}', 'apiGatewayController@showWallet');

Route::post('walletAdd/{id}', 'apiGatewayController@addMoney');

Route::post('pay', 'apiGatewayController@pagarRenda');





Route::get('homeInteressado', 'apiGatewayController@showHomeInteressado');

Route::get('interessadoProfile/{id}', 'apiGatewayController@showInteressadoProfile');

Route::get('walletInteressado/{id}', 'apiGatewayController@showWalletInteressado');

Route::get('findPropriedadeInteressado/{idUser}', 'apiGatewayController@encontrarPropriedade');

