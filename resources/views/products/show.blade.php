@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach($data as $d)
                <div class="card-header"><h3>{{ $d['product_name'] }}</h3></div>

                <div id="message" class="card-body">
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


                    <div class="row">
                        <div class="col">
                            <img src="{{ asset('/images/products/'.$d['img']) }}" alt="product image" width="250">
                        </div>
                        <div class="col">
                            <p>{{ $d['desc'] }}</p>
                            <h3 class="mb-4">₱ {{ $d['unit_price'] }}</h3>
                            <div class="form-row mb-4" >
                                <div class="col-3">
                                    <label>Quantity</label>
                                </div>
                                <div class="col-3">
                                    <input id="qty" type="number" class="form-control" name="qty" min="1" max="{{ $d['quantity']}}" value="1">
                                </div>
                            </div>
                            <p>{{ $d['quantity'] }} pieces available</p>
                            <div class="form-row mb-4">
                                <div class="col">
                                    <button type="button" data-id="{{ $d['product_id']}}" id="add-to-cart" class="btn btn-warning btn-block"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-info btn-block"><i class="fa fa-credit-card" aria-hidden="true"></i> Buy now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>

$(document).ready(function() {

    function add_to_cart(qty, prod_id) {
        $.ajax({
            url: "/cart",
            method: "POST",
            data: {qty: qty, product_id: prod_id, _token: "{{ csrf_token() }}", _method: 'POST'},
            success: function(data) {
                var output = '';
                output += '<div id="message" class="alert alert-success" role="alert">';
                output += 'Successfully added to cart!';
                output += '</div>';
                $(output).insertBefore('.card-body');
                output = '';

            },
            error: function(err) {
                var output = '';
                output += '<div id="message" class="alert alert-warning" role="alert">';
                output += 'Cannot add to cart. Item out of stock!';
                output += '</div>';
                $(output).insertBefore('.card-body');
                output = '';
            }
        });
    }

    $('#add-to-cart').click(function(){
        var qty = $('#qty').val();
        var prod_id = $(this).data("id");
        add_to_cart(qty, prod_id);
    });

});

</script>
@endsection