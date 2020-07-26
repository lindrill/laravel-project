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
            ->orderBy('created_at', 'desc')
            ->get();

        $del = DB::table('deliveries')
            ->orderBy('created_at', 'desc')
            ->get();
        $delivery_prod = $del
            ->groupBy('product_id');

        $groups = [];
        foreach ($delivery_prod as $key => $dp) {
            array_push($groups, $dp->first());
        }

        return view('delivery.index', compact('deliveries', 'groups'));
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
        $products = Product::all();
        $delivery = DB::table('deliveries')
            ->join('products', 'products.id', '=', 'deliveries.product_id')
            ->select('deliveries.*', 'products.name')
            ->where('deliveries.id', '=', $id)
            ->get();
        return view('delivery.edit', compact('delivery', 'products'));
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
        $request->validate([
            'receipt_no' => 'required|string',
            'quantity' => 'required|integer',
            'product_id' => 'required'
        ]);

        $delivery = Delivery::find($id);
        $delivery->receipt_no = $request->receipt_no;
        $delivery->quantity = $request->quantity;
        $delivery->product_id = $request->product_id;
        $delivery->save();

        if($delivery->save()) {
            return back()->with('message', 'Delivery saved!');
        } else {
            return back()->with('message', 'Delivery was not saved.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id)->delete();
        return back()->with('message', 'Delivery deleted successfully!');
    }
}
