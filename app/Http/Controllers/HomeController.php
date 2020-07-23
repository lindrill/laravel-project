<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Delivery;
use DB;

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
        // $products = DB::table('products')
        //     ->leftJoin('deliveries', 'products.id', '=', 'deliveries.product_id')
        //     ->select('deliveries.*', 'products.*')
        //     ->get();
        $deliveries = Delivery::all();
        // return view('delivery.index', compact('deliveries'));

        $products = Product::all();

        // foreach ($deliveries as $delivery) {
        //     $data['id'] = $product->id;
        //     $data['name'] = $product->name;

            foreach ($deliveries as $delivery) {
                // if($delivery->product_id == $product->id) {
                    $data['quantity'] = $delivery->quantity;
                // }
            }
        // }
        dd($data);

        return view('home', compact('products', 'deliveries'));
    }
}
