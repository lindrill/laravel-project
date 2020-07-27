@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

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
                            <div class="input-group mb-3">
                                  <input id="search_text" type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2" name="search">
                                  <div class="input-group-append">
                                    <button id="search_product" class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                  </div>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ url('/products/create') }}"><button type="button" class="btn btn-primary btn-large"><i class="fas fa-plus"></i> Add Product</button></a>
                        </div>
                        
                    </div>

                    
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
                                        <img src="{{ asset('/images/products/'.$product->photo) }}" width="80" alt="" title="{{ $product->name }}">
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit_price }}</td>
                                    <td>
                                        <a href="products/{{$product->id}}/edit"><button type="button" class="btn btn-success btn-sm"><i class="far fa-edit"></i></button></a>
                                        <form style="display: inline;" action="{{ url('products', [$product->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')";><i class="far fa-trash-alt"></i></button>
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
                        output += "<tr>";
                        output += "<td id='prod_id'>"+data[count].id+"</td>";
                        output += "<td>"+data[count].name+"</td>";
                        output += '<td><img src="'+img_url+'/'+data[count].photo+'" width="80" alt="" title="'+data[count].name+'"></td>';
                        output += "<td>"+data[count].description+"</td>";
                        output += "<td>"+data[count].unit_price+"</td>";
                        output += "<td>";
                        output += '<a href="products/'+data[count].id+'/edit"><button type="button" class="btn btn-success btn-sm"><i class="far fa-edit"></i></button></a>';
                        output += '<button id="delete_btn" data-id="'+data[count].id+'"class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>';
                        output += "</td>";
                        output += "</tr>";
                    }
                } else {
                    output += "<tr>";
                    output += "<td>No data found</td>";
                    output += "</tr>";
                }
                $('tbody').html(output);
            }
        });
    }

    function delete_product(prod_id = '') {
        var _token = $("input[name=_token]").val();
        $.ajax({
            type: 'DELETE',
            url: "/products/"+prod_id,
            data: {id: prod_id, _token:_token, _method: 'DELETE'},
            dataType: "json",
            success: function() {
                console.log("DELETED");
            }
        });
    }

    $('#search_product').click(function(){
        var search_product_query = $('#search_text').val();
        load_data(search_product_query);
    });

    $(document).on('click', '#delete_btn', function(e) {
        window.confirm("Are you sure?");
        var prod_id = $(this).data("id");
        delete_product(prod_id);
    });
});

</script>
@endsection