<?php
use App\auction;
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->middleware('role.base');

Route::get('/login' , function(){
    return view('login');
})->middleware('role.base');

Route::get('/register' , function(){
	return view('register');
});


Route::get('/new/auction' , 'AuctionController@create');
Route::post('/new/auction' , 'AuctionController@store');

Route::get('/test/date' , function(){
    $date1 = date('y-m-d' , strtotime('1-1-2018'));
    $date2 = date('y-m-d' , strtotime('5-3-2018'));
    echo $date1 . ' ------  ' . $date2 . '<br>';
    
    
    $x= (date_diff(date_create($date2),date_create($date1)));
    echo $x->y . ' - ' . $x->m . ' - ' . $x->d;
 
});

Route::get('/home' , function(){
return view('home');
})->name('homeRoute');

Route::get('/panel' , function(){
    return view('admin.index');
})->name('adminPanel');

Route::get('/auction/details/{id}' , function($id){
    return view('auction.details' , compact('id'));
});

Route::get('/pivot', function(){
    $user =User::find(2);
    
    foreach ($user->auctions as $role) {
        echo ( $role->pivot->bid_amount);
    }
});

// social Authentication
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');