@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
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

                    <div class="row">
                        <div class="col-md-8" style="background: #d4f7e5; padding: 10px;">
                            <input id="search_text" type="text" class="form-control" placeholder="Search product" aria-describedby="basic-addon2" name="search" style="width: 180px; display: inline; margin-right: 20px;">

                            From
                            <input id="from_date" type="date" name="from_date">
                            To
                            <input id="to_date" type="date" name="to_date">
                            <button id="search_product" class="btn btn-warning" type="submit" style="margin-left: 20px;">Search</button>
                        </div>
                        <div class="col-md-4 text-right">
                            <a id="href-export-pdf" href="{{ url('sales_pdf', ['null', 'null', 'null']) }}">
                                <button class="btn btn-success">Export PDF</button>
                            </a>
                        </div>
                        
                    </div>

                    
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Sales/ Order ID</th>
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
                                    <td>{{ $sale->sales_id }}</td>
                                    <!-- Carbon\Carbon::parse($sale->sales_date)->format('M d, Y h:m:s') -->
                                    <td>{{ $sale->sales_date }}</td>
                                    <td>{{ $sale->product_id }}</td>
                                    <td>
                                        <img src="{{ asset('/images/products/'.$sale->photo) }}" width="80">
                                        <p>{{ $sale->name }}</p>
                                    </td>
                                    <td>{{ number_format($sale->unit_price, 2) }}</td>
                                    <td>
                                        {{ $sale->quantity }}
                                    </td>
                                    <td>{{ $sale->user_name }}</td>
                                    <td>₱ {{ number_format($sale->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-footer text-right">
                        <h4 id="total-sales">Total Sales: ₱ {{ number_format($total_sales, 2) }}</h4>
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
    var pdf_url = "{{ URL::to('/sales_pdf') }}";

    function search_data(search_val, from_date, to_date) {
        var _token = $("input[name=_token]").val();
        $.ajax({
            url: "/search_sales",
            method: "GET",
            data: {search: search_val, from_date: from_date, to_date: to_date, _token:_token},
            dataType: "json",
            success: function(data) {
                var output = '';
                var total_sales = 0;
                if(data.length > 0) {
                    for(var count = 0; count < data.length; count++) {

                        var amount = parseFloat(data[count].amount);

                        output += "<tr>";
                        output += "<td>"+data[count].sales_id+"</td>";
                        output += "<td>"+data[count].sales_date+"</td>";
                        output += "<td>"+data[count].id+"</td>";
                        output += "<td>";
                        output += "<img src='"+img_url+"/"+data[count].photo+"' width='80'>";
                        output += "<p>"+data[count].name+"</p>";
                        output += "</td>";
                        output += "<td>"+data[count].unit_price+"</td>";
                        output += "<td>"+data[count].quantity+"</td>";
                        output += "<td>"+data[count].user_name+"</td>";
                        output += "<td>"+amount.toFixed(2)+"</td>";
                        output += "</tr>";

                        total_sales = (parseFloat(total_sales) + parseFloat(data[count].amount)).toFixed(2);
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
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        if(search == '') {
            search = null;
        }
        if(from_date == '') {
            from_date = null;
        }
        if(to_date == '') {
            to_date = null;
        }
        $("#href-export-pdf").attr("href", pdf_url+"/"+search+"/"+from_date+"/"+to_date);

        search_data(search, from_date, to_date);
    });

});

</script>
@endsection