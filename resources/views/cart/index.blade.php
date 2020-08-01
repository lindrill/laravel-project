@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Cart') }}</div>

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

                    <div class="row text-center">
                        <div class="col-md-6">
                            <!-- <div class="input-group mb-3">
                                <a href="#"><button type="button" class="btn btn-secondary btn-large">Add Delivery</button></a>
                            </div> -->
                        </div>
                        <div class="col">
                            
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" id="save-changes-to-cart" class="btn btn-primary btn-large">Save Changes to Cart</button></a>
                        </div>
                        
                    </div>

                    <br><br>
                    <table id="cart-table" class="table-cart" style="text-align: center;">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Item</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cart)
                                @foreach($stocks as $stock)
                                    @if($cart->product->id == $stock['product_id'])
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            </div>
                                        </th>
                                        <th scope="row">
                                            <img src="{{ asset('/images/products/'.$cart->product->photo) }}" width="80" alt="" title="">
                                            <p class="mt-2">{{ $cart->product->name }}</p>
                                        </th>
                                        <td id="unit_price">{{ $cart->product->unit_price }}</td>
                                        <td>
                                            <button id="qty-add" data-id="{{$cart->id}}" style="display: inline;" class="btn btn-secondary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <input type="text" id="quantity" class="form-control" style="width:35%; display: inline;" value="{{ $cart->quantity }}" min="1" max="{{ $stock['quantity'] }}">
                                            <button id="qty-minus" data-id="{{$cart->id}}" class="btn btn-secondary btn-sm"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                        </td>

                                        <?php $cart_total_price = $cart->product->unit_price * $cart->quantity; ?>
                                        <td id="total_price">{{ $cart_total_price }}</td>
                                        <td>
                                            <form style="display: inline;" action="/cart/{{$cart->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="delete-cart" class="btn btn-danger btn-sm" data-id= {{ $cart->id }} onclick="return confirm('Are you sure?')";><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

$(document).ready(function(){

    function update_cart(carts) {

        $.ajax({
            url: "/update_cart/",
            method: "POST",
            data: {carts: carts, _token: "{{ csrf_token() }}", _method: 'PUT'},
            dataType: "json",
            success: function(data) {
                var output = '';
                output += '<div id="message" class="alert alert-success" role="alert">';
                output += 'Changes saved!';
                output += '</div>';
                $(output).insertBefore('.card-body');
            }
        });
    }

    $('.table-cart tbody').on('click', '#qty-add', function() {
        $(this).each(function(index, tr) {

            var row = $(this).closest('tr');
            var quantity_val = row.find('#quantity').val();
            var unit_price = row.find('#unit_price').text();
            var total_price = row.find('#total_price').text();

            row.find('#quantity').val(Number(quantity_val) + 1);
            row.find('#total_price').text(parseInt(total_price) + parseInt(unit_price));

            // set min value size
            var max = row.find('#quantity').attr('max');

            if(quantity_val == max) {
                row.find('#quantity').val(max);
                row.find('#total_price').text(parseInt(unit_price) * parseInt(max));
            }
        });
    });

    $('.table-cart tbody').on('click', '#qty-minus', function() {
        $(this).each(function(index, tr) {
            var row = $(this).closest('tr');
            var quantity_val = row.find('#quantity').val();
            var unit_price = row.find('#unit_price').text();
            var total_price = row.find('#total_price').text();

            row.find('#quantity').val(quantity_val);

            // set min value size
            var min = row.find('#quantity').attr('min');

            if(quantity_val > min) {
                row.find('#quantity').val(Number(quantity_val) - 1);
                total_price = parseFloat(total_price) - unit_price;
            } else {
                quantity_val = parseInt(quantity_val) - 1;
            }
        
            row.find('#total_price').text(total_price);
        });
    });

    var carts = [];
    $('#save-changes-to-cart').click(function(){
        $('.table-cart > tbody > tr').each(function(index, tr) {
            var tds = $(this).find('td');
            var cart_id = tds.find('#qty-add').data("id");
            var quantity = tds.find('#quantity').val();
            var total = $(this).find('#total_price').text();
            var unit_price = $(this).find('#unit_price').text();

            carts.push({
                id: cart_id, 
                quantity: quantity,
                amount: total,
                unit_price: unit_price
            });
        });
        update_cart(carts);
    });
});

</script>
@endsection
