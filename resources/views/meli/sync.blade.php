@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
<div class="row">
    <div class="col-md-12">
        <h5 class="text-bold text-dark mt-5">Sincronización con Mercadolibre</h5>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sicronizar</h3>
                <div class="card-tools">
                <span class="badge badge-primary">Label</span>
                </div>
            </div>
            <div class="card-body">

                @if (session()->has('success'))
                    <br>
                    <div class="col-md-12">
                        <div class="alert alert-success mt-2">
                            {{ session()->get('success') }}
                        </div>
                    </div>
                @endif

                <a href="{{route('meli.updatevehicles')}}" class="btn btn-primary">Sincronizar Vehiculos</a>

            </div>
            <div class="card-footer">
                The footer of the card
            </div>
        </div>

    </div>
</div>
@endsection
