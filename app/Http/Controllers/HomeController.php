<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Delivery;
use DB;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();
        $deliveries = Delivery::all();
        $products = Product::all();

        $del = [];
        $p_ids = [];
        $qty;
        foreach ($deliveries as $delivery) {
            foreach ($products as $product) {
                if($delivery->product_id == $product->id) {
                    if(empty($data)) { // first iteration
                        $qty = $delivery->quantity;
                        $del['quantity'] = $qty;
                        $del['product_id'] = $delivery->product_id;
                        $del['product_name'] = $product->name;
                        $del['img'] = $product->photo;
                        array_push($p_ids, $delivery->product_id); 
                        array_push($data, $del);
                    } else {
                        if(in_array($delivery->product_id, $p_ids)) {
                            foreach ($data as $key => $value) {
                                if($delivery->product_id == $value['product_id']) {
                                    $data[$key]['quantity'] += $delivery->quantity;
                                }
                            }
                        } else {
                            $qty = $delivery->quantity;
                            $del['quantity'] = $qty;
                            $del['product_id'] = $delivery->product_id;
                            $del['product_name'] = $product->name;
                            $del['img'] = $product->photo;
                            array_push($p_ids, $delivery->product_id); 
                            array_push($data, $del);
                        }
                    }
                }
            }
        }

        return view('home', compact('data'));
    }

    public function edit($product_id)
    {
        $delivery = DB::table('deliveries')
            ->join('products', 'products.id', '=', 'deliveries.product_id')
            ->select('deliveries.*', 'products.name')
            ->where('product_id', $product_id)
            ->latest()
            ->first();

        return view('delivery.edit-stocks', compact('delivery'));
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
        $info_validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
        ]);

        $delivery = Delivery::find($id);
        $delivery->quantity = $request->quantity;
        $delivery->save();
        if($delivery->save()) {
            return back()->with('message', 'Delivery updated successfully!');
        }
    }
}
