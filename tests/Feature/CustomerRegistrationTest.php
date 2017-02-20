<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use Carbon\Carbon;

class CustomerRegistrationTest extends TestCase
{  
	use DatabaseMigrations;
  use DatabaseTransactions;

  public function testBinaryPlacement()
  {
    $admin = factory(Customer::class)->create(['username' => 'admin']); 

    $child1 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $admin->id,
      'direction' => 'L',
    ]); 

    $child2 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $admin->id,
      'direction' => 'R',
    ]); 

    $placement_child1_id = Customer::lastPlacement('L', $admin->id)->id;
    $placement_child2_id = Customer::lastPlacement('R', $admin->id)->id;    

    $this->assertTrue($child1->id === $placement_child1_id);
    $this->assertTrue($child2->id === $placement_child2_id);

    $child3 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $child1->id,
      'direction' => 'L',
    ]); 

    $child4 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $child2->id,
      'direction' => 'R',
    ]); 

    $placement_child3_id = Customer::lastPlacement('L', $admin->id)->id;
    $placement_child4_id = Customer::lastPlacement('R', $admin->id)->id;    

    $this->assertTrue($child3->id === $placement_child3_id);
    $this->assertTrue($child4->id === $placement_child4_id);
  }

  public function testBinaryPlacementFails()
  {
    $admin = factory(Customer::class)->create(['username' => 'admin']); 

    $child1 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $admin->id,
      'direction' => 'L',
    ]); 

    $child2 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $admin->id,
      'direction' => 'R',
    ]); 

    $child3 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $child2->id,
      'direction' => 'L',
    ]); 

    $child4 = factory(Customer::class)->create([
      'sponsor_id' => $admin->id, 
      'placement_id' => $child1->id,
      'direction' => 'R',
    ]); 

    $placement_child3_id = Customer::lastPlacement('L', $admin->id)->id;
    $placement_child4_id = Customer::lastPlacement('R', $admin->id)->id;    

    $this->assertFalse($child3->id !== $placement_child3_id);
    $this->assertFalse($child4->id !== $placement_child4_id);
  }

  public function testRegisterCustomerLeft()
  {
    $admin = factory(Customer::class)->create(['username' => 'admin']);

    $c1 = factory(Customer::class)->create([
      'direction' => 'L', 
      'sponsor_id' => $admin->id, 
      'placement_id' => $admin->id,
    ]);

    $customer = [
      'username' => 'vong_tach',
      'first_name' => 'Vong',
      'last_name' => 'Tach',
      'gender' => 'M',
      'country_id' => '12',
      'date_of_birth' => '2017-02-08',
      'email' => 'vong_tach@mail.com',
      'password' => '123456',
      'password_confirmation' => '123456',
      'bitcoin_account' => 'rgfegfref',
      'sponsor_id' => $admin->id,
      'direction' => 'L',
      'agree_term_condition' => 'on',
    ]; 

    $response = $this->post('/register', $customer);

    $response->assertStatus(200);
    $this->assertDatabaseHas('customers', [
      'username' => 'vong_tach',
      'email' => 'vong_tach@mail.com',
      'sponsor_id' => $admin->id,
      'placement_id' => $c1->id,
      'direction' => 'L',
    ]);
  }

  public function testRegisterCustomerRight()
  {
    $parent = factory(Customer::class)->create(['username' => 'admin2']);

    $cu1 = factory(Customer::class)->create([
      'direction' => 'R', 
      'sponsor_id' => $parent->id,
      'placement_id' => $parent->id,
    ]);

    $customer2 = [
      'username' => 'vong_tach2',
      'first_name' => 'Vong2',
      'last_name' => 'Tach2',
      'gender' => 'M',
      'country_id' => '12',
      'date_of_birth' => '2017-02-08',
      'email' => 'vong_tach2@mail.com',
      'password' => '123456',
      'password_confirmation' => '123456',
      'bitcoin_account' => 'rgfegfref',
      'sponsor_id' => $parent->id,
      'direction' => 'R',
      'agree_term_condition' => 'on',
    ]; 

    $response = $this->post('/register', $customer2);

    $response->assertStatus(200);
    $this->assertDatabaseHas('customers', [
      'username' => 'vong_tach2',
      'email' => 'vong_tach2@mail.com',
      'sponsor_id' => $parent->id,
      'placement_id' => $cu1->id,
      'direction' => 'R',
    ]);
  }
}
