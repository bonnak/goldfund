<?php

use Illuminate\Database\Seeder;
use App\CompanyProfile;

class WhatIsForexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyProfile::insert([
        	[ 'field' => 'what-is-forex', 'value' => '' ],
        ]);
    }
}
