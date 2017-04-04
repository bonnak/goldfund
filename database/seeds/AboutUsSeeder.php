<?php

use Illuminate\Database\Seeder;
use App\CompanyProfile;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyProfile::insert([
        	[ 'field' => 'about-us', 'value' => '' ],
        ]);
    }
}
