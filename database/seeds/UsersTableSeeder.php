<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//$faker = Factory::create();

    	User::truncate();

    	factory(User::class)->create(['username' => 'admin']);
        factory(User::class, 20)->create();
    }
}
