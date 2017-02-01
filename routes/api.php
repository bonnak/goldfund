<?php

Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function(){

	Route::get('/user', function(){
		return ['Adam', 'Eva'];
	});

});
