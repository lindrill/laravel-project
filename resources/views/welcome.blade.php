@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6">
        <h2>Products</h2>
    </div>
    <div class="d-flex flex-wrap justify-content-center"> 
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug2.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug3.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug2.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="card">
                <a href="#">
                    <img src="{{URL::asset('/images/products/ghibli-mug3.jpg')}}" alt="Logo" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="#">Product name</a></h6>
                    <h5>₱ 100.00</h5>
                    <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                </div>
            </di

    </div> 

    <!-- <div class="row justify-content-center">
          <div class="row">
            <div class="col">
                <div class="card">
                    <a href="#">
                        <img src="{{URL::asset('/images/products/ghibli-mug.jpg')}}" alt="Logo" width="250">
                    </a>
                    <div class="text-center mt-2">
                        <h6><a href="#">Product name</a></h6>
                        <h5>₱ 100.00</h5>
                        <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="#">
                        <img src="{{URL::asset('/images/products/ghibli-mug.jpg')}}" alt="Logo" width="250">
                    </a>
                    <div class="text-center mt-2">
                        <h6><a href="#">Product name</a></h6>
                        <h5>₱ 100.00</h5>
                        <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="">
                        <img src="{{URL::asset('/images/products/ghibli-mug.jpg')}}" alt="Logo" width="250">
                    </a>
                    <div class="text-center mt-2">
                        <h6><a href="#">Product name</a></h6>
                        <h5>₱ 100.00</h5>
                        <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                    </div>
                </div>
            </div>

           
          </div>
    </div> -->
</div>
@endsection