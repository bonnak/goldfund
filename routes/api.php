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
Route::get('/plans', 'Api\PlanController@all');

Route::group(['middleware' => 'auth:api'], function(){
	Route::put('/user/updateProfile', 'Api\UserController@updateProfile');
	Route::put('/password/change', 'Api\UserController@changePassword');
	Route::post('/transaction/auth', 'UserController@authorizeTransaction');

	//Deposit
	Route::post('/deposit', 'DepositController@create');
	Route::get('/deposit/history', 'DepositController@history');

	//Earning
	Route::get('/transactions', 'EarningController@transactions');
	Route::get('/earning/daily', 'EarningController@daily_earning');
	Route::get('/earning/level', 'EarningController@level_earning');
	Route::get('/earning/binary', 'EarningController@binary_earning');

	//Withdrawal
	Route::get('/withdrawal/balance', 'WithdrawalController@getData');
	Route::post('/withdrawal/cashout', 'WithdrawalController@cashOut');
	Route::get('/withdrawal/history', 'WithdrawalController@history');

	//Dashboard	
	Route::get('/earning/data', 'DashboardController@getData');

	//Binary
	Route::get('/binary/json', 'BinaryController@getData');


	Route::post('/photo/upload', 'DepositController@upload');
});
