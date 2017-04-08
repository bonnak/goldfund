<?php

use Illuminate\Database\Seeder;
use App\Slide;
use Carbon\Carbon;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slide::truncate();

        Slide::insert([
        	['image' => '/storage/images/slide/1.png', 'order' => 1],
        	['image' => '/storage/images/slide/2.jpg', 'order' => 2],
        	['image' => '/storage/images/slide/3.jpg', 'order' => 3],
        	['image' => '/storage/images/slide/4.jpg', 'order' => 4],
        	['image' => '/storage/images/slide/5.jpg', 'order' => 5],
        	['image' => '/storage/images/slide/6.jpg', 'order' => 6],
        ]);
    }
}
