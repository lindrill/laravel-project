<head>
 <title>{{ $data['title'] }}</title>
</head>
<body>
  <h3>{{ $data['title'] }}</h3>
  <p>Product keyword: {{ $data['keyword'] }}</p>
  <p>Start date: {{ $data['start_date'] }}</p>
  <p>End date: {{ $data['end_date'] }}</p>
  <div>
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
                    <td>P {{ $sale->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer">
        <h4 style="text-align: right;" id="total-sales">Total Sales: P {{ number_format($total_sales, 2) }}</h4>
    </div>
  </div>
</body>
</body>
</html>