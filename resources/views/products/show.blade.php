@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach($data as $d)
                <div class="card-header"><h3>{{ $d['product_name'] }}</h3></div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col">
                            <img src="{{ asset('/images/products/'.$d['img']) }}" alt="product image" width="250">
                        </div>
                        <div class="col">
                            <p>{{ $d['desc'] }}</p>
                            <h3 class="mb-4">₱ {{ $d['unit_price'] }}</h3>
                            <div class="form-row mb-4" >
                                <div class="col-3">
                                    <label>Quantity</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control" name="qty" min="1" max="{{ $d['quantity']}}">
                                </div>
                            </div>
                            <p>{{ $d['quantity'] }} pieces available</p>
                            <div class="form-row mb-4" >
                                <div class="col">
                                    <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-credit-card" aria-hidden="true"></i> Buy now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
