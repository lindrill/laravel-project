@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sales') }}</div>

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

                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                  <input id="search_text" type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2" name="search">
                                  <div class="input-group-append">
                                    <button id="search_product" class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                  </div>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                        <div class="col-md-4 text-right">
                            
                        </div>
                        
                    </div>

                    
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale['id'] }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$sale['photo']) }}" width="80">
                                        <p>{{ $sale['product_name'] }}</p>
                                    </td>
                                    <td>{{ $sale['unit_price'] }}</td>
                                    <td>
                                        {{ $sale['quantity'] }}
                                    </td>
                                    <td>₱ {{ $sale['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <h4>Total Sales: ₱ {{ $total_sales }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection