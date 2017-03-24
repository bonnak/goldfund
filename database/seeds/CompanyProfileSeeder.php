<?php

use Illuminate\Database\Seeder;
use App\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyProfile::truncate();

        CompanyProfile::insert([
        	[ 'field' => 'address', 'value' => 'PO Box 16122 Collins Street West, Victoria 8007 Australia' ],
        	[ 'field' => 'email', 'value' => 'contact@designlab.com' ],
        	[ 'field' => 'phone', 'value' => '012887657' ],
        ]);
    }
}
