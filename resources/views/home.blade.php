@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-md-4 text-right">
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                        <div class="col-md-4 text-right">
                           <a href="{{ url('/products/create') }}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add product</button></a>
                           <a href=""><button type="button" class="btn btn-warning"><i class="fas fa-plus"></i> Add delivery</button></a>
                        </div>
                        
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">No. of Available Stocks</th>
                            <th scope="col">Update Stocks</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @foreach($deliveries->products as $delivery)

                                        @endforeach
                                    </td>
                                    <td>
                                        <a href=""><button type="button" class="btn btn-info btn-sm"><i class="fas fa-plus"></i></button></a>
                                        <a href=""><button type="button" class="btn btn-info btn-sm"><i class="fas fa-minus"></i></button></a>
                                    </td>
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
