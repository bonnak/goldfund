<?php

/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api_admin'], function(){

	Route::get('/users', 'Admin\UserController@users');

	Route::get('/customers', 'Admin\CustomerController@customers');

	Route::get('/deposit/history', 'Admin\DepositController@history');
	Route::post('/deposit/approve', 'Admin\DepositController@approve');

	//Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');
	Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');

	//Customer
	Route::put('/customer/email', 'Admin\CustomerController@editEmail');
	Route::put('/customer/bitcoin/address', 'Admin\CustomerController@editBitcoinAddress');

	//Plan
	Route::get('/plans', 'Admin\PlanController@get');

	//Geneology
	Route::get('/geneology/json', 'Admin\GeneologyController@getData');

	//Withdrawal
	Route::get('/withdrawal', 'Admin\WithdrawalController@getData');
	Route::post('/withdrawal/approve', 'Admin\WithdrawalController@approve');

	//Company profile
	Route::get('company/profile', 'Admin\CompanyProfileController@getData');
	Route::put('company/profile', 'Admin\CompanyProfileController@update');
});


/***
 * Front-end
 */
Route::get('/portfolio/live', 'PortfolioController@live');
Route::get('qr/admin/bitcoin', 'Api\QrController@adminBitCoinAccountQrImage');
Route::get('/plans', 'Api\PlanController@all');

Route::group(['middleware' => 'auth:api'], function(){
	Route::put('/user/update', 'Api\UserController@updateProfile');
	Route::put('/password/change', 'Api\UserController@changePassword');
	Route::post('/user/photo/upload', 'Api\UserController@upload');
	Route::post('/transaction/auth', 'UserController@authorizeTransaction');

	//Deposit
	Route::post('/deposit', 'DepositController@create');
	Route::get('/deposit/history', 'DepositController@history');

	//Earning
	Route::get('/transactions', 'EarningController@transactions');
	Route::get('/earning/daily', 'EarningController@dailyEarning');
	Route::get('/earning/level', 'EarningController@levelEarning');
	Route::get('/earning/level/{level_number}', 'EarningController@filterLevelEarning');
	Route::get('/earning/binary', 'EarningController@binaryEarning');
	Route::get('/earning/direct', 'EarningController@directEarning');

	//Withdrawal
	Route::get('/withdrawal/balance', 'WithdrawalController@getData');
	Route::post('/withdrawal/cashout', 'WithdrawalController@cashOut');
	Route::get('/withdrawal/history', 'WithdrawalController@history');

	//Dashboard	
	Route::get('/earning/data', 'DashboardController@getData');

	//Geneology
	Route::get('/binary/json', 'BinaryController@getData');


	Route::post('/photo/upload', 'DepositController@upload');

	//Level sponsor 
	Route::get('/plan/levels', 'LevelController@get');

	//Company profile
	Route::get('company/profile', 'CompanyProfileController@getData');


	// Customer send mail
	Route::post('customer/message', 'UserController@sendMessage');
});
