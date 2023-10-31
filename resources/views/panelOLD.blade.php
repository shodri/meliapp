@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Panel') }}</div>

                <div class="card-body">
                    <div class="list-group">
                        <a class="list-group-item" href="{{ route('products.index')}}">
                            Manage Products
                        </a>
                        <a class="list-group-item" href="{{ route('users.index')}}">
                            Manage Users
                        </a>
                    </div>

                    {{ __('You are logged in panel !') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
