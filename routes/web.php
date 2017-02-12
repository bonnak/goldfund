<?php
/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth:admin'],function(){
	Route::get('/', function(){
		return view('admin.index');
	});
});

Route::group(['prefix' => 'admin'], function(){
	Route::get('login', 'Admin\Auth\LoginController@loginForm');
	Route::post('login', 'Admin\Auth\LoginController@login');
	Route::get('logout', 'Admin\Auth\LoginController@logout');
});



/***
 * Front-end
 */
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/account',  'UserController@index');
	Route::get('/logout', 'Auth\LoginController@logout');

	Route::get('/user/getProfile', 'Api\UserController@getProfile');
	Route::put('/user/updateProfile', 'Api\UserController@getProfile');

	//Deposit
	Route::get('/deposit', 'DepositController@showForm')->name('deposit');
	Route::post('/deposit', 'DepositController@create');
});


Route::get('/', function(){
	return view('home');

	//dd($customer = \App\Customer::find(1)->toArray());

	//$customer->notify(new \App\Notifications\VerifyCustomerRegister());
});

Route::get('/home', 'HomeController@index');

Route::get('/about-us', function(){
	return view('about-us');
});

Route::get('/contact-us', function(){
	return view('contact-us');
});

Route::get('/term', function(){
	return view('term');
});

Route::get('/news', function(){
	return view('news');
});

Route::get('/faq', function(){
	return view('faq');
});

Route::get('/support', function(){
	return view('support');
});

Route::get('live', function(){
    event(new \App\Events\NewMemberRegistered(\App\Customer::find(1)));
});