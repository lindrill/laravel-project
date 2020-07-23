@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Deliveries') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/deliveries/create') }}"><button type="button" class="btn btn-secondary btn-large">Add Delivery</button></a>
                    <br><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Receipt</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($deliveries as $delivery)
                                <tr>
                                    <th scope="row">{{ $delivery->id }}</th>
                                    <th scope="row">{{ $delivery->receipt_no }}</th>
                                    <td>{{ $delivery->name }}</td>
                                    <td>{{ $delivery->quantity }}</td>
                                    <td>{{ $delivery->created_at }}</td>
                                    <td>
                                        <a href="#"><button type="button" class="btn btn-success btn-sm"><i class="far fa-edit"></i></button></a>
                                        <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
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
