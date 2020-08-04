@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('My purchased items') }}</div>

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
                    
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <td scope="col">Order ID</td>
                            <th scope="col">Date</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($user_sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->created_at }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$sale->product->photo) }}" width="80">
                                        <p>{{ $sale->product->name }}</p>
                                    </td>
                                    <td>{{ $sale->product->unit_price }}</td>
                                    <td>
                                        {{ $sale->quantity }}
                                    </td>

                                    <td>₱ {{ $sale->product->unit_price * $sale->quantity }}</td>  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection