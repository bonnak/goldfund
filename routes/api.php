<?php

/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api_admin'], function(){
	Route::get('/auth/user', function(){
		return auth()->user();
	});

	Route::get('/users', 'Admin\UserController@users');

	Route::get('/customers', 'Admin\CustomerController@getData');

	Route::get('/deposit', 'Admin\DepositController@getData');
	Route::post('/deposit/approve', 'Admin\DepositController@approve');

	//Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');
	Route::post('/earning/money/daily', 'Admin\EarningController@sendDailyMoney');

	//Customer
	Route::put('/customer/email', 'Admin\CustomerController@editEmail');
	Route::put('/customer/bitcoin/address', 'Admin\CustomerController@editBitcoinAddress');

	//Plan
	Route::get('/plans', 'Admin\PlanController@get');
	Route::put('/plan/edit', 'Admin\PlanController@update');

	//Geneology
	Route::get('/geneology/json', 'Admin\GeneologyController@getData');

	//Withdrawal
	Route::post('/withdrawal/approve', 'Admin\WithdrawalController@approve');
	Route::post('/withdrawal/cancel', 'Admin\WithdrawalController@cancel');
	Route::get('/withdrawal', 'Admin\WithdrawalController@getData');

	//Company profile
	Route::get('/company/profile', 'Admin\CompanyProfileController@getData');
	Route::put('/company/profile', 'Admin\CompanyProfileController@update');

	//Page
	Route::get('/faq', 'Admin\FaqController@getData');
	Route::post('/faq', 'Admin\FaqController@create');
	Route::put('/faq/update', 'Admin\FaqController@update');
	Route::get('/page/about-us', 'Admin\PageController@aboutUs');
	Route::put('/page/about-us', 'Admin\PageController@updateAboutUs');
	Route::get('/page/what-is-forex', 'Admin\PageController@whatIsForex');
	Route::put('/page/what-is-forex', 'Admin\PageController@updateWhatIsForex');
	Route::get('/page/service/bitcoin-mining', 'Admin\PageController@bitcoinMining');
	Route::put('/page/service/bitcoin-mining', 'Admin\PageController@updateBitcoinMining');
	Route::get('/page/service/forex-trading', 'Admin\PageController@forexTrading');
	Route::put('/page/service/forex-trading', 'Admin\PageController@updateForexTrading');
	Route::get('/page/service/gold-trading', 'Admin\PageController@goldTrading');
	Route::put('/page/service/gold-trading', 'Admin\PageController@updateGoldTrading');

	//Setting
	Route::get('/setting/slide', 'Admin\SlideController@getData');
	Route::post('/setting/slide', 'Admin\SlideController@addNew');
	Route::delete('/setting/slide/{id}', 'Admin\SlideController@delete');
	Route::put('/setting/slide', 'Admin\SlideController@update');

	//News	
	Route::get('/news', 'PostController@news');
	Route::post('/news', 'PostController@create');
	Route::put('/news', 'PostController@update');
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
	Route::get('/deposit/current', 'DepositController@current');

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
	Route::post('/withdrawal/cancel', 'WithdrawalController@cancel');
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

	Route::get('/payment/crypto', 'PaymentController@index');

	//News
	Route::get('/news/latest', 'PostController@latestNews');
	Route::get('/news', 'PostController@get');
	Route::get('/news/{id}', 'PostController@getById');
});
