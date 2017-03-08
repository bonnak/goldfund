<?php

/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api_admin'], function(){

	Route::get('/users', 'Admin\UserController@users');

	Route::get('/customers', 'Admin\CustomerController@customers');

	Route::get('/deposit/history', 'Admin\DepositController@history');
	Route::post('/deposit/{id}/approve', 'Admin\DepositController@approve');

	//Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');
	Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');
});


/***
 * Front-end
 */
Route::get('/portfolio/live', 'PortfolioController@live');
Route::get('qr/admin/bitcoin', 'Api\QrController@adminBitCoinAccountQrImage');

Route::group(['middleware' => 'auth:api'], function(){
	Route::put('/user/updateProfile', 'Api\UserController@updateProfile');
	Route::put('/password/change', 'Api\UserController@changePassword');

	//Deposit
	Route::post('/deposit', 'DepositController@create');
	Route::get('/deposit/history', 'DepositController@history');

	//Earning
	Route::get('/earning/data', 'EarningController@getData');
});
Route::get('/plans', 'Api\PlanController@all');
