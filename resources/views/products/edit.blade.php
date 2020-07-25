@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Product') }}</div>

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

                    <form action="{{ url('products', [$product->id]) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Product Name:</label>
                            <input type="text" class="form-control" id="inputEmail4" name="name" value="{{ $product->name }}" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            <label>Product Description:</label>
                            <input type="text" class="form-control" id="inputPassword4" name="desc" value="{{ $product->description }}" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label>Unit Price:</label>
                            <input type="text" class="form-control" id="inputPassword4" name="unit_price" value="{{ $product->unit_price }}" placeholder="Unit Price">
                        </div>
                         <div class="form-group">
                            <label for="exampleInputEmail1">Product photo:</label><br>
                            <img src="{{ asset('/images/products/'.$product->photo) }}" width="100" alt="" title="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Change photo:</label><br>
                            <input  type="file" id="myfile" name="photo">
                        </div>
                      <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
