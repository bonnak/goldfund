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
        	[ 'field' => 'email', 'value' => 'bitcompanytrading@gmail.com' ],
        	[ 'field' => 'phone', 'value' => '+18882936433' ],
            [ 'field' => 'bitcoin_address', 'value' => '18yPTZTbHFVwpcPrUSUMhy3b91vKcwutdK' ],
        ]);
    }
}
