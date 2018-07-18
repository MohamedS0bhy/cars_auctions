<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class auction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'auctions';
    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_name', 'price', 'start_bid_amount',
        'pics', 'location', 'start_bid_date',
        'end_bid_date'
    ];
}
