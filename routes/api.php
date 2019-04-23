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

//Route::group(['middleware' => ['api']], function () {
    Route::post('Auth', 'API\UserController@auth');
    Route::get('Bills', 'API\BillController@listBills');
    Route::get('Cards', 'API\CardController@listCards');
    Route::get('CardDetail', 'API\CardController@show');
//});

Route::group(['middleware' => 'session.alive'], function() {
    Route::get('/a', function () {
       return 'sadsaa';
    });
});
