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

   /**
     * @test
     */
    public function register_direct_children_without_sponsor()
    {
        $admin = factory(Customer::class)->create([ 'username' => 'admin']);

        $direct_right = [
            'username' => 'vong_tach3',
            'first_name' => 'Vong2',
            'last_name' => 'Tach2',
            'gender' => 'M',
            'country_id' => '12',
            'date_of_birth' => '2017-02-08',
            'email' => 'vong_tach2@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'bitcoin_account' => 'rgfegfref',
            'sponsor_id' => $admin->id,
            'direction' => 'R',
            'agree_term_condition' => 'on',
        ]; 

        $response = $this->post('/register', $direct_right);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'vong_tach3',
            'sponsor_id' => $admin->id,
            'placement_id' => $admin->id,
            'direction' => 'R',
        ]);
   }

   /**
     * @test
     */
    public function register_indirect_children_without_sponsor()
    {
        $admin = factory(Customer::class)->create([ 'username' => 'admin']);
        $direct_right = factory(Customer::class)->create([
            'sponsor_id' => $admin->id,
            'placement_id' => $admin->id,
            'direction' => 'R',
        ]);

        $indirect_right_1 = [
            'username' => 'indirect_right_1',
            'first_name' => 'Vong2',
            'last_name' => 'Tach2',
            'gender' => 'M',
            'country_id' => '12',
            'date_of_birth' => '2017-02-08',
            'email' => 'indirect_right_1@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'bitcoin_account' => 'rgfegfref',
            'sponsor_id' => $admin->id,
            'direction' => 'R',
            'agree_term_condition' => 'on',
        ]; 

        $response = $this->post('/register', $indirect_right_1);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'indirect_right_1',
            'sponsor_id' => $admin->id,
            'placement_id' => $direct_right->id,
            'direction' => 'R',
        ]);

        $indirect_right_2 = [
            'username' => 'indirect_right_2',
            'first_name' => 'Vong2',
            'last_name' => 'Tach2',
            'gender' => 'M',
            'country_id' => '12',
            'date_of_birth' => '2017-02-08',
            'email' => 'indirect_right_2@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'bitcoin_account' => 'rgfegfrefdfdfd',
            'sponsor_id' => $admin->id,
            'direction' => 'R',
            'agree_term_condition' => 'on',
        ]; 

        $response = $this->post('/register', $indirect_right_2);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'indirect_right_2',
            'sponsor_id' => $admin->id,
            'placement_id' => Customer::where('username', 'indirect_right_1')->first()->id,
            'direction' => 'R',
        ]);
   }

    /**
     * @test
     */
    public function register_direct_children_from_sponsor()
    {
        $admin = factory(Customer::class)->create([ 'username' => 'admin']);
        $parent = factory(Customer::class)->create([
            'sponsor_id' => $admin->id,
            'placement_id' => $admin->id,
            'direction' => 'R',
        ]);

        $direct_right = [
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

        $response = $this->post('/register', $direct_right);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'vong_tach2',
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'R',
        ]);
   }

   /**
     * @test
     */
    public function register_indirect_children_with_sponsor()
    {
        $admin = factory(Customer::class)->create([ 'username' => 'admin']);
        $parent = factory(Customer::class)->create([
            'sponsor_id' => $admin->id,
            'placement_id' => $admin->id,
            'direction' => 'R',
        ]);
        $direct_right = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'R',
        ]);

        $indirect_right_1 = [
            'username' => 'indirect_right_1',
            'first_name' => 'Vong2',
            'last_name' => 'Tach2',
            'gender' => 'M',
            'country_id' => '12',
            'date_of_birth' => '2017-02-08',
            'email' => 'indirect_right_1@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'bitcoin_account' => 'rgfegfref',
            'sponsor_id' => $parent->id,
            'direction' => 'R',
            'agree_term_condition' => 'on',
        ]; 

        $response = $this->post('/register', $indirect_right_1);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'indirect_right_1',
            'sponsor_id' => $parent->id,
            'placement_id' => $direct_right->id,
            'direction' => 'R',
        ]);

        $indirect_right_2 = [
            'username' => 'indirect_right_2',
            'first_name' => 'Vong2',
            'last_name' => 'Tach2',
            'gender' => 'M',
            'country_id' => '12',
            'date_of_birth' => '2017-02-08',
            'email' => 'indirect_right_2@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'bitcoin_account' => 'rgfegfrefdfdfd',
            'sponsor_id' => $parent->id,
            'direction' => 'R',
            'agree_term_condition' => 'on',
        ]; 

        $response = $this->post('/register', $indirect_right_2);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'username' => 'indirect_right_2',
            'sponsor_id' => $parent->id,
            'placement_id' => Customer::where('username', 'indirect_right_1')->first()->id,
            'direction' => 'R',
        ]);
   }
}
