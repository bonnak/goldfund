<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerRegistrationTest extends TestCase
{
	use DatabaseTransactions;

  public function testRegister()
  {
  	// $this->visit('/register')
  	// 		->type('Bonnak', 'first_name')
  	// 		->type('Chea', 'last_name')
  	// 		->select('M', 'gender')
  	// 		->select('1', 'country_id')
  	// 		->type('1990-01-01', 'date_of_birth')
  	// 		->type('bonnak', 'username')
  	// 		->type('bonnak@mail.com', 'email')
  	// 		->type('123456', 'password')
  	// 		->type('123456', 'password_confirmation')
  	// 		->type('cvbnmelxihldjh', 'bitcoin_account')
  	// 		->type('1', 'sponsor_id')
  	// 		->select('Right', 'direction')
  	// 		->seeInDatabase('customers', [
  	// 			'username' => 'bonnak',
  	// 			'email' => 'bonnak@mail.com',  				
  	// 			'first_name' => 'Bonnak',
  	// 			'last_name' => 'Chea',
  	// 			'gender' => 'M',
  	// 			'country_id' => '1',
  	// 		]);	  	
  }
}
