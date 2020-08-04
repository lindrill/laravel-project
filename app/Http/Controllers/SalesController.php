<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Cart;
use App\Product;
use Auth;
use DB;
use Carbon\Carbon;
use PDF;

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
            ->select('sales.*', 'sales.id as sales_id', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
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

    public function search_sales(Request $request) {

        $search = $request->search;
        $from_date = $request->from_date . ' 00:00:00';
        $to_date = $request->to_date . ' 23:59:59';

        $sales = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->join('carts', 'sales.cart_id', '=', 'carts.id')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->select('sales.*', 'sales.id as sales_id', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
            ->where('products.name', 'like', '%' .$search. '%');

            if(!empty($request->from_date) && !empty($request->to_date)) {
                $sales->where(function($query) use ($from_date, $to_date){
                  $query->orWhereBetween('sales.created_at', [$from_date, $to_date]);
                });
            }
        $sales = $sales->get();
        return response()->json($sales);
    }

    public function export_pdf($keyword, $start_date, $end_date)
    {
        if($keyword == 'null' && $start_date == 'null' && $end_date == 'null') {
            $sales = DB::table('sales')
                ->join('products', 'sales.product_id', '=', 'products.id')
                ->join('carts', 'sales.cart_id', '=', 'carts.id')
                ->join('users', 'sales.user_id', '=', 'users.id')
                ->select('sales.*', 'sales.id as sales_id', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
                ->get();

            $first_date = $sales[0]->sales_date;
            $last_date = $sales[count($sales) - 1]->sales_date;

            $data = [
                'title' => 'Sales Report of All Products',
                'start_date' => $first_date,
                'end_date' => $last_date,
                'keyword' => $keyword
            ];

            $pdf = PDF::loadView('pdf_view', compact('sales', 'data'));
            return $pdf->download('all-products-sales-report.pdf');

        } else {

            if($keyword == 'null') {
                $keyword = '';
            }

            $from_date = $start_date . ' 00:00:00';
            $to_date = $end_date . ' 23:59:59';

            $sales = DB::table('sales')
                ->join('products', 'sales.product_id', '=', 'products.id')
                ->join('carts', 'sales.cart_id', '=', 'carts.id')
                ->join('users', 'sales.user_id', '=', 'users.id')
                ->select('sales.*', 'sales.id as sales_id', 'sales.created_at as sales_date', 'products.*', 'carts.amount', 'users.name as user_name')
                ->where('products.name', 'like', '%' .$keyword. '%');

                if(($start_date != 'null' || $end_date != 'null')) {
                    $sales->where(function($query) use ($from_date, $to_date) {
                        $query->orWhereBetween('sales.created_at', [$from_date, $to_date]);
                    });
                }

            $sales = $sales->get();
            
            $data = [
                'title' => 'Sales Report',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'keyword' => $keyword
            ];

            $pdf = PDF::loadView('pdf_view', compact('sales', 'data')); 
            return $pdf->download('sales-report.pdf');
        }
        
    }
}
