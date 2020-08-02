<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\Delivery;
use Auth;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $carts = Cart::with('product')->get();
        $deliveries = Delivery::all();
        $products = Product::all();
        $stocks = app('App\Http\Controllers\HomeController')->get_stocks($deliveries, $products);
        return view('cart.index', compact('carts', 'stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prod_id = $request->product_id;
        $products = Product::where('id', $prod_id)->get();
        $deliveries = Delivery::all();
        $num_stocks = 0;
        $cart = Cart::where('product_id', $prod_id)->first();

        // checking available stocks before adding to cart
        $stocks = app('App\Http\Controllers\HomeController')->get_stocks($deliveries, $products);

        foreach ($stocks as $key => $value) {
            $num_stocks = $value['quantity'];
        }

        if(count($stocks) != 0 || $num_stocks != 0) {
            if(!$cart) {
                $qty = 1;

                if($request->qty) {
                    $qty = $request->qty;
                }

                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->product_id = $prod_id;
                $cart->quantity = $qty;
                
                foreach($products as $product) {
                    $cart->amount = $product->unit_price; 
                }
                $cart->save();

                if($cart->save()) {
                    return back()->with('message', 'Successfully added to cart!');
                } else {
                    return back()->with('message', 'Adding to cart failed!');
                }
                return back()->with('message', 'Successfully added to cart!');

                return response()->json(["message" => "Item already added to cart!"]);
            } else {
                return back()->with('message', 'Item already added to cart!');

                return response()->json(["message" => "Item already added to cart!"]);
            }
        } else {
            return back()->with('message', 'Cannot add to cart. Item out of stock!');
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

    public function update_cart(Request $request)
    {

        $items = $request->carts;

        foreach ($items as $key => $value) {
            $cart = Cart::find($items[$key]['id']);
            $cart->quantity = $items[$key]['quantity'];
            $amount = $items[$key]['quantity'] * $items[$key]['unit_price'];
            $cart->amount = $amount;
            $cart->save();
        }

        return response()->json("Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id)->delete();
        return back()->with('message', 'Item deleted successfully!');
    }
}
