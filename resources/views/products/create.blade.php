@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Product') }}</div>

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

                    <form action="{{ url('products') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEmail4" name="name" value="" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPassword4" name="desc" value="" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPassword4" name="unit_price" value="" placeholder="Unit Price">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Upload a photo:</label><br>
                            <input  type="file" id="myfile" name="photo">
                        </div>
                      <button type="submit" class="btn btn-primary">Save Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
