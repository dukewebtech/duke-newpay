<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::POST('verify/{accountNumber}/{serviceType}','BaxiServiceController@verifyAccount');
Route::POST('paystack/verify/{reference}','BaxiServiceController@verifyTransaction');
Route::POST('pay/subscription','BaxiServiceController@paySubscription');
