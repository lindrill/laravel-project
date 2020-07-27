@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-md-4 text-right">
                            <div class="input-group mb-3">
                              <input type="text" id="search_text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2" name="search">
                              <div class="input-group-append">
                                <button id="search_product" class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                        <div class="col-md-4 text-right">
                           <a href="{{ url('/products/create') }}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add product</button></a>
                           <a href=""><button type="button" class="btn btn-warning"><i class="fas fa-plus"></i> Add delivery</button></a>
                        </div>
                        
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Photo</th>
                            <th scope="col">No. of Available Stocks</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $data)
                                <tr>
                                    <th scope="row">{{ $data['product_id'] }}</th>
                                    <td>{{ $data['product_name'] }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$data['img']) }}" width="50" alt="" title="">
                                    </td>
                                    <td>{{ $data['quantity'] }}</td>
                                    <td>
                                        <a href="stocks/{{$data['product_id']}}/edit"><button type="button" class="btn btn-info btn-sm">Update stock</button></a>
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
        console.log(search_val);
        var _token = $("input[name=_token]").val();
        $.ajax({
            url: "/search_delivery_product",
            method: "GET",
            data: {search: search_val, _token:_token},
            dataType: "json",
            success: function(data) {
                console.log(data);
                var output = '';
                if(data.length > 0) {
                    for(var count = 0; count < data.length; count++) {
                        output += "<tr>";
                        output += "<td>"+data[count].product_id+"</td>";
                        output += "<td>"+data[count].product_name+"</td>";
                        output += "<td>"+data[count].quantity+"</td>";
                        output += '<td><img src="'+img_url+'/'+data[count].img+'" width="80" alt="" title="'+data[count].name+'"></td>';
                        output += '<td><a href="stocks/'+data[count].product_id+'/edit"><button type="button" class="btn btn-info btn-sm">Update stock</button></a></td>';
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

    $('#search_product').click(function(){
        var search_product_query = $('#search_text').val();
        load_data(search_product_query);
    });
});

</script>
@endsection
