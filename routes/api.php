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
