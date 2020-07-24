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
                            <th scope="col">Photo</th>
                            <th scope="col">No. of Available Stocks</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $data)
                                <tr>
                                    <th scope="row">{{ $data['product_id'] }}</th>
                                    <td>{{ $data['product_name'] }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$data['img']) }}" width="50" alt="" title="">
                                    </td>
                                    <td>{{ $data['quantity'] }}</td>
                                    <td>
                                        <a href="stocks/{{$data['product_id']}}/edit"><button type="button" class="btn btn-info btn-sm">Update stock</button></a>
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
