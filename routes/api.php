<?php

/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function(){

	Route::get('/users', 'Admin\UserController@users');

	Route::get('/customers', 'Admin\CustomerController@customers');

});


/***
 * Front-end
 */
Route::get('/portfolio/live', 'PortfolioController@live');
Route::get('qr/admin/bitcoin', 'Api\QrController@adminBitCoinAccountQrImage');

Route::group(['middleware' => 'auth:api'], function(){
	Route::put('/user/updateProfile', 'Api\UserController@updateProfile');
	Route::put('/password/change', 'Api\UserController@changePassword');
});