@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My account') }}</div>

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

                    <form action="{{ url('update_account', [$user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEmail4" name="name" value="{{$user->name}}" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="inputPassword4" name="email" value="{{$user->email}}" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputPassword4" name="address" value="{{$user->address}}" placeholder="Complete address">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="inputCity" name="phone_no" value="{{$user->phone_no}}" placeholder="Phone number">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="inputZip" name="postal_code" value="{{$user->postal_code}}" placeholder="Postal Code">
                            </div>
                        </div>
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
