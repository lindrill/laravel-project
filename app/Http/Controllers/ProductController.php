<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
        $imageName = time().'.'.$request->photo->extension();  
   
        $request->photo->move(public_path('images/products'), $imageName);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->desc,
            'unit_price' => $request->unit_price,
            'photo' => $imageName
        ]);

        if($product->save()) {
            return redirect('/products')->with('message', 'Product added!');
        } else {
            return back()->with('message', 'Product was not saved.');
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
        $product = Product::find($id);
        return view('products.edit', compact('product'));
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
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'desc' => 'required',
            'unit_price' => 'required'
        ]);

        $product = Product::find($id);

        if($request->photo) {
            // remove existing photo if there's new upload
            unlink(public_path('/images/products/'.$product->photo));

            $imageName = time().'.'.$request->photo->extension();  
       
            $request->photo->move(public_path('images/products'), $imageName);
            $product->photo = $imageName;
        }
        
        $product->name = $request->name;
        $product->description = $request->desc;
        $product->unit_price = $request->unit_price;        
        $product->save();

        if($product->save()) {
            return back()->with('message', 'Product updated!');
        } else {
            return back()->with('message', 'Product was not updated.');
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
        $product = Product::find($id);
        unlink(public_path('/images/products/'.$product->photo));
        $product->delete();
        return redirect('/products')->with('message', 'Product deleted successfully!');
    }

    

    public function search_product(Request $request) {
        if($request->ajax()){
            $products = Product::search($request->get('search'))->get();
            return response()->json($products);
        }
    }
}
