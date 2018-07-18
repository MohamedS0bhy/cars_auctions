<?php

use Illuminate\Database\Seeder;
use App\auction;

class auctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auction = auction::create([
            'car_name' => 'car1',
            'price' => 3000,
            'start_bid_amount' => 100,
            'pics' => "[noimg.jpg]",
            'location' => 'cairo,egypt',
            'start_bid_date' => date('Y-m-d'),
            'end_bid_date' => date("Y-m-d", strtotime("+ 1 day"))
        ]);

        $auction = auction::create([
            'car_name' => 'car2',
            'price' => 3000,
            'start_bid_amount' => 100,
            'pics' => "[noimg.jpg]",
            'location' => 'cairo,egypt',
            'start_bid_date' => date('Y-m-d'),
            'end_bid_date' => date("Y-m-d", strtotime("+ 1 day"))
        ]);
    }
}
