@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col">
        <div class="row text-center">
            <div class="col">
                <h2>Products</h2>
            </div>
            <div class="col text-right">
               
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        @foreach($products as $product)
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{ asset('/images/products/'.$product->photo) }}" alt="product image" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">{{ $product->name }}</a></h6>
                    <h5>{{ $product->unit_price }}</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div> 
</div>
@endsection