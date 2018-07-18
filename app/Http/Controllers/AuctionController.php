<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\GuzzleException;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auction.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [

            'pics' => 'required',
            'pics.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $start_bid_date = date('Y-m-d', strtotime($request->input('start_bid_date')));
        $end_bid_date = date('Y-m-d', strtotime($request->input('end_bid_date')));
        $today = date('Y-m-d');
        if($start_bid_date < $today || $end_bid_date < $today || $start_bid_date > $end_bid_date)
            return back()->with('failed' , 'invalid start or end date');

        $imgs = array();
        $i=1;
        foreach($request->pics as $image){
            $newImgName = 'image'.$i.'_' . time() . '.' .$image->extension();
            $image->move(public_path('uploads') ,  $newImgName);
            $imgs[] =  $newImgName;
            $i++;
        }

        $client = new Client();
        $response = $client->post('http://127.0.0.1:8000/api/auction/add',[
            RequestOptions::JSON => [
                'token' => (isset($_COOKIE['token'])) ? $_COOKIE['token'] : 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTUzMTgyMDM3OCwiZXhwIjoxNTMxODIzOTc4LCJuYmYiOjE1MzE4MjAzNzgsImp0aSI6InN1Qk5lb2RYdmxxTXJUQkciLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.1wqhKSN_7EufccNOQc9XixVkxRv_5Yy9Ey6JXTOKPrI',
                'car_name' => $request->car_name,
                'price' => $request->price,
                'start_bid_amount' => $request->start_bid_amount,
                'pics' => json_encode($imgs),
                'location' => $request->location,
                'start_bid_date' => $start_bid_date,
                'end_bid_date' => $end_bid_date
                ]
        ]);
        $r = json_decode($response->getBody()->getContents());
        if( $r->success ){
            return back()->with('success' , 'added successfully');
        }else{
            return back()->with('failed' , $r->result);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
