@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="/dashboard"><i class="fas fa-arrow-left"></i></a> {{ __('Update Latest Delivery') }}</div>

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

                    <form action="{{ url('stocks', [$delivery->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Receipt No:</label>
                            <input type="text" class="form-control" id="inputEmail4" name="receipt_no" value="{{ $delivery->receipt_no}}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Product Name:</label>
                            <input type="text" class="form-control" id="inputEmail4" name="product_name" value="{{ $delivery->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="inputPassword4" name="quantity" value="{{ $delivery->quantity }}" placeholder="Quantity">
                        </div>
                      <button type="submit" class="btn btn-primary">Update Stock</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

