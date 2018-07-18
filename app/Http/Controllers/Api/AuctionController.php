<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\auction;
use JWTAuth;
use JWTAuthException;

class AuctionController extends Controller
{

    // get all auctions 
    public function getAll(){
        return response()->json([
            'success' => true,
            'result' => auction::all(),
        ]);
        
    }

    public function getAllOpen(){
        return response()->json([
            'success' => true,
            'result' => auction::where('state','open')->get(),
        ]);
    }

    // find specific auction
    public function find($id){
        $auction = auction::find($id);
        if($auction)
            return response()->json([
                'success' => true,
                'result' => auction::find($id),
            ]);

        return response()->json([
            'success' => false,
            'result' => "This Auction Cannot be found !",
        ]);
    }

    // add new auction
    // only admin who is authorized to add auction
    public function add(Request $request){
        
        $user = JWTAuth::toUser($request->input('token'));        
        
        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        if($user->role != '1')
            return response()->json([
                'success' =>false , 
                'result' => 'You\'re not Authorized to take such this action!!'
                ]);

        $start_bid_date = date('Y-m-d', strtotime($request->input('start_bid_date')));
        $end_bid_date = date('Y-m-d', strtotime($request->input('end_bid_date')));
        $today = date('Y-m-d');
        if($start_bid_date < $today || $end_bid_date < $today || $start_bid_date > $end_bid_date)
            return response()->json([
                'success' =>false , 
                'result' => 'invalid start or end date'
                ]);
        

        $auction = auction::create([
            'car_name' => $request->input('car_name'),
            'price' => $request->input('price'),
            'start_bid_amount' => $request->input('start_bid_amount'),
            'pics' => $request->input('pics'),
            'location' => $request->input('location'),
            'start_bid_date' => $start_bid_date,
            'end_bid_date' => $end_bid_date
        ]);

        if($auction)
            return response()->json([
                'success' =>true , 
                'result' => $auction
                ]);

        return response()->json([
            'success' =>false , 
            'result' => 'failed to add auction !'
            ]);
    }

    // change auction state [open , closed]
    // only admin who is authorized to change state
    // if it changed from open to close endDate = null
    // otherwise endDate will be the new bid end date
    public function changeState(Request $request){

        $user = JWTAuth::toUser($request->input('token'));

        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        if($user->role != '1')
            return response()->json([
                'success' =>false ,
                'result' => 'You\'re not Authorized to take such this action!!'
                ]);

        $endDate = $request->input('endDate');

        $auction = auction::find($request->input('id'));

        $auction->state = $request->input('state');
        if(!is_null($endDate)){
            $today = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($endDate));
            
            if( $endDate < $today || $auction->start_bid_date > $endDate)
                return response()->json([
                    'success' =>false , 
                    'result' => 'invalid end date'
                    ]);
            $auction->end_bid_date = $endDate ;

        }
        if($auction->save())
            return response()->json([
                'success' =>true ,
                'result' => 'Auction state updated successfully !'
                ]);

        return response()->json([
            'success' =>false ,
            'result' => 'failed to update auction state'
            ]);
    }

    // adding bid to auction
    public function addBid(Request $request){
        $user = JWTAuth::toUser($request->input('token'));

        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        $auction = auction::find($request->input('id'));
        $bid = $request->input('bid');

        $start_bid_date = date('Y-m-d', strtotime($auction->start_bid_date));
        $end_bid_date = date('Y-m-d', strtotime($auction->end_bid_date));
        $today = date('Y-m-d');
        if($today < $start_bid_date)
            return response()->json([
                'success' =>false,
                'result' => 'Auction doesn\'t start yet !'
                ]);

        elseif($today > $end_bid_date)
            return response()->json([
                'success' =>false,
                'result' => 'Auction has finished !'
                ]);

        if($bid <= $auction->start_bid_amount)
            return response()->json([
                'success' =>false,
                'result' => 'your bid is less than required !'
                ]);

        if($auction->state == 'closed')
            return response()->json([
                'success' =>false,
                'result' => 'Cannot add bid for closed Auctions !'
                ]);

        $attach = $user->auctions()->attach($request->input('id') , ['bid_amount' => $bid]);
        $auction->start_bid_amount = $bid;
        $auction->save();

        return response()->json([
            'success' =>true,
            'result' => $attach
            ]);
    }

}
