<?php

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

Auth::routes();

Route::get('/my-account', function(){
	return view('my-account');
})->middleware('auth');


Route::get('/', function(){
	return view('home');
});
Route::get('/home', function(){
	return view('home');
});
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
