@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/products/create') }}"><button type="button" class="btn btn-secondary btn-large">Add Product</button></a>
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Description</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <th scope="row">{{ $product->name }}</th>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$product->photo) }}" width="80" alt="" title="">
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit_price }}</td>
                                    <td>
                                        <a href="products/{{$product->id}}/edit"><button type="button" class="btn btn-success btn-sm"><i class="far fa-edit"></i></button></a>
                                        <form style="display: inline;" action="{{ url('products', [$product->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')";><i class="far fa-trash-alt"></i></button>
                                        </form>
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
