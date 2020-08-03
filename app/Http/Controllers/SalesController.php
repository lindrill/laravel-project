<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Cart;
use App\Product;
use Auth;
use DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sales = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->join('carts', 'sales.cart_id', '=', 'carts.id')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->select('sales.*', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
            ->get();

        return view('sales.index', compact('sales'));
        
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
        $items = $request->sales;
        $sales_items = Sale::all();

        foreach ($items as $key => $value) {
            $sales_items = Sale::where('cart_id', $value['cart_id'])->get();
            if(!$sales_items || count($sales_items) == 0) {
                $sale = new Sale();
                $sale->cart_id = $value['cart_id'];
                $sale->product_id = $value['product_id'];
                $sale->user_id = Auth::user()->id;
                $sale->quantity = $value['quantity'];
                $cart = Cart::find($value['cart_id'])->delete();
                $sale->save();
            }
        }

        return response()->json(["message" => "Placed order!"]);
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

    public function purchase()
    {
        $user_sales = Sale::where('user_id', Auth::user()->id)->with('product')->get();
        $products = Product::all();
        return view('sales.purchase', compact('user_sales', 'products'));
    }

    // public function get_sales($products) {

            // dd($sales);
        // $sales_ids = Sale::groupBy('product_id')->pluck('product_id');
        // $products = Product::groupBy('id')
        //             ->whereIn('id', $sales_ids)
        //             ->with('sale')
        //             ->get();

        // $sales = $this->get_sales($products);

        
    //     $sales = array();
    //     $items = [];
    //     $total_sales = 0;
    //     foreach ($products as $key => $product) {
    //         $quantity = 0;
    //         foreach ($product->sale as $sale) {

    //             $items['id'] = $product->id;
    //             $items['product_name'] = $product->name;
    //             $items['unit_price'] = $product->unit_price;
    //             $items['photo'] = $product->photo;
                
    //             if($product->id == $sale->product_id) {
    //                 $quantity += $sale->quantity;
    //             }
    //         }

    //         $items['quantity'] = $quantity;
    //         $total = $quantity * $product->unit_price;
    //         $items['total'] = $total;
    //         $total_sales += $total;

    //         array_push($sales, $items);
    //     }
    //     $sales['total_sales'] = $total_sales;
        
    //     return $sales;

    // }

    public function search_sales(Request $request) {
        $search = $request->search;

        $sales_by_product_name = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->join('carts', 'sales.cart_id', '=', 'carts.id')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->select('sales.*', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
            ->where('products.name', 'like', '%' .$search. '%')
            ->get();

        return response()->json($sales_by_product_name);
    }
}
