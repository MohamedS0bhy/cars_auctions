<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::get('auction/all' , 'Api\AuctionController@getAll');
Route::get('auction/open/all' , 'Api\AuctionController@getAllOpen');
Route::get('auction/{id}' , 'Api\AuctionController@find');


Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('getUser', 'Api\AuthController@getAuthUser');
    
    Route::post('auction/add' , 'Api\AuctionController@add');
    Route::post('auction/state/change' , 'Api\AuctionController@changeState');
    Route::post('auction/new/bid' , 'Api\AuctionController@addBid');
});