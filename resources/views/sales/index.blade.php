@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Sales') }}</div>

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
                            
                        </div>
                        
                    </div>

                    
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Sales ID</th>
                            <th scope="col">Date/Time Purchased</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">User</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $total_sales = 0; ?>
                            @foreach($sales as $sale)
                                <tr>
                                    <?php $total_sales += $sale->amount; ?>
                                    <td>{{ $sale->id }}</td>
                                    <!-- Carbon\Carbon::parse($sale->sales_date)->format('M d, Y h:m:s') -->
                                    <td>{{ $sale->sales_date }}</td>
                                    <td>{{ $sale->product_id }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$sale->photo) }}" width="80">
                                        <p>{{ $sale->name }}</p>
                                    </td>
                                    <td>{{ $sale->unit_price }}</td>
                                    <td>
                                        {{ $sale->quantity }}
                                    </td>
                                    <td>{{ $sale->user_name }}</td>
                                    <td>₱ {{ $sale->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <h4 id="total-sales">Total Sales: ₱ {{ $total_sales }}</h4>
                    </div>
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

    function search_data(search_val) {
        var _token = $("input[name=_token]").val();
        $.ajax({
            url: "/search_sales",
            method: "GET",
            data: {search: search_val, _token:_token},
            dataType: "json",
            success: function(data) {
                var output = '';
                var total_sales = 0;
                if(data.length > 0) {
                    for(var count = 0; count < data.length; count++) {
                        output += "<tr>";
                        output += "<td>"+data[count].id+"</td>";
                        output += "<td>"+data[count].sales_date+"</td>";
                        output += "<td>"+data[count].id+"</td>";
                        output += "<td>";
                        output += "<img src='"+img_url+"/"+data[count].photo+"' width='80'>";
                        output += "<p>"+data[count].name+"</p>";
                        output += "</td>";
                        output += "<td>"+data[count].unit_price+"</td>";
                        output += "<td>"+data[count].quantity+"</td>";
                        output += "<td>"+data[count].user_name+"</td>";
                        output += "<td>"+data[count].amount+"</td>";
                        output += "</tr>";

                        total_sales = parseFloat(total_sales) + parseFloat(data[count].amount);
                    }
                } else {
                    output += "<tr>";
                    output += "<td>No data found</td>";
                    output += "</tr>";
                }
                console.log('total_sales', total_sales);
                $('#total-sales').text("Total Sales: ₱" + total_sales);
                $('tbody').html(output);
                
            }
        });
    }

    $('#search_product').click(function(){
        var search = $('#search_text').val();
        console.log("clicked", search);
        search_data(search);
    });

});

</script>
@endsection