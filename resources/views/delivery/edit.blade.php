@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ __('Edit Delivery') }}</div>

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
                    @foreach($delivery as $d)
                    <form action="{{ url('deliveries', [$d->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Receipt No:</label>
                            <input type="text" class="form-control" id="inputEmail4" name="receipt_no" value="{{ $d->receipt_no}}">
                        </div>
                        <div class="form-group">
                            <div class="btn-group">
                                <select name="product_id">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}"

                                        @if($d->product_id == $product->id)
                                            selected
                                        @endif 
                                        >{{ $product->name }}

                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="inputPassword4" name="quantity" value="{{ $d->quantity }}" placeholder="Quantity">
                        </div>
                      <button type="submit" class="btn btn-primary">Update Stock</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

