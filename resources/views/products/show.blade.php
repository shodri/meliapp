@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-4">
            @include('components.product-card', ['test' => 'testing'])
        </div>
    </div>
@endsection
