<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Auction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('car_name');
            $table->enum('state' , ['open' , 'closed'])->default('open');
            $table->double('price');
            $table->double('start_bid_amount');
            $table->longText('pics');
            $table->string('location');
            $table->date('start_bid_date');
            $table->date('end_bid_date');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction', function (Blueprint $table) {
            //
        });
    }
}
