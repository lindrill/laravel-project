<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delivery;
use DB;
use App\Product;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = DB::table('deliveries')
            ->join('products', 'products.id', '=', 'deliveries.product_id')
            ->select('deliveries.*', 'products.name')
            ->get();
        return view('delivery.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::select('id','name')->get();
        return view('delivery.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'receipt_no' => 'required|string',
            'quantity' => 'required|integer',
            'product_id' => 'required'
        ]);
  
        $delivery = Delivery::create([
            'receipt_no' => $request->receipt_no,
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
        ]);

        if($delivery->save()) {
            return back()->with('message', 'Delivery saved!');
        } else {
            return back()->with('message', 'Delivery was not saved.');
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
