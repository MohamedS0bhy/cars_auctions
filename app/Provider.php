<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

	protected $fillable = [
        'provider',
        'provider_id',
    	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
