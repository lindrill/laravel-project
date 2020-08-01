@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col">
        <div class="row text-center">
            <div class="col">
                <h2>Products</h2>
            </div>
            <div class="col text-right">
               
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group mb-3">
                  <input id="search_text" type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button id="search_product" class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div id="products_section" class="d-flex flex-wrap justify-content-center">
        @foreach($data as $d)
        <div class="p-3">
            <div class="card">
                
                <a href="{{ url('stock', [$d['product_id']]) }}">
                    <img src="{{ asset('/images/products/'.$d['img']) }}" alt="product image" width="250">
                </a>
                <div class="text-center mt-2">
                    <h6><a href="{{ url('stock', [$d['product_id']]) }}">{{ $d['product_name'] }}</a></h6>
                    <h5>{{ $d['unit_price'] }}</h5>
                    <form method="POST" action="{{ url('cart') }}">
                        @csrf
                        @method('POST')
                        <input name="product_id" type="hidden" value="{{ $d['product_id'] }}">
                        <button type="submit" class="btn btn-warning btn-block">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div> 
</div>
@endsection

@section('script')
<script>

$(document).ready(function(){
    
    var img_url = "{{ asset('/images/products/') }}";

    function load_data(search_product_query = '') {
        var search_val = $("#search_text").val();
        var _token = $("input[name=_token]").val();
        $.ajax({
            url: "/search_product",
            method: "GET",
            data: {search: search_val, _token:_token},
            dataType: "json",
            success: function(data) {
                var output = '';
                if(data.length > 0) {
                    for(var count = 0; count < data.length; count++) {
                        output += '<div class="p-3">';
                        output += '<div class="card">';
                        output += '<a href="stock/'+data[count].product_id+'">';
                        output += '<a href="stock/'+data[count].product_id+'">';
                        output += '<img src="'+img_url+'/'+data[count].photo+'" alt="product image" width="250">';
                        output += '</a>';
                        output += '<div class="text-center mt-2">';
                        output += '<h6><a href="stock/"'+data[count].product_id+'>'+data[count].name+'</a></h6>';
                        output += '<h5>'+data[count].unit_price+'</h5>';
                        output += '<button class="btn btn-warning btn-block">Add to cart</button>';
                        output += '</div>';
                        output += '</div>';
                        output += '</div>';
                    }
                } else {
                    output += "No data found";
                }
                $('#products_section').html(output);
            }
        });
    }

    function add_to_cart(search_product_query = '') {
        var search_val = $("#search_text").val();
        var _token = $("input[name=_token]").val();
        $.ajax({
            url: "/search_product",
            method: "GET",
            data: {search: search_val, _token:_token},
            dataType: "json",
            success: function(data) {
                var output = '';
                if(data.length > 0) {
                    for(var count = 0; count < data.length; count++) {
                        output += '<div class="p-3">';
                        output += '<div class="card">';
                        output += '<a href="stock/'+data[count].product_id+'">';
                        output += '<a href="stock/'+data[count].product_id+'">';
                        output += '<img src="'+img_url+'/'+data[count].photo+'" alt="product image" width="250">';
                        output += '</a>';
                        output += '<div class="text-center mt-2">';
                        output += '<h6><a href="stock/"'+data[count].product_id+'>'+data[count].name+'</a></h6>';
                        output += '<h5>'+data[count].unit_price+'</h5>';
                        output += '<button class="btn btn-warning btn-block">Add to cart</button>';
                        output += '</div>';
                        output += '</div>';
                        output += '</div>';
                    }
                } else {
                    output += "No data found";
                }
                $('#products_section').html(output);
            }
        });
    }

    $('#search_product').click(function(){
        var search_product_query = $('#search_text').val();
        load_data(search_product_query);
    });
});

</script>
@endsection