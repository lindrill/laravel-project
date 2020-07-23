@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Delivery') }}</div>

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

                    <form action="{{ url('deliveries') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEmail4" name="receipt_no" value="" placeholder="Receipt Number">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="inputPassword4" name="quantity" value="" placeholder="Quantity">
                        </div>
                       
                        <div class="form-group">

                            <div class="btn-group">
                                <select name="product_id">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      <button type="submit" class="btn btn-primary">Save Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

