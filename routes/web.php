<?php

Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'],function(){
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

Route::get('/', function(){
	return view('welcome');
});