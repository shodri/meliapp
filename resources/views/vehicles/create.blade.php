@extends('adminlte::page')
@include('layouts.js') 

@section('plugins.Select2', true)
<style>
    .select2-container--default .select2-selection--single {
        height: 2.5rem !important;
    }
</style>



@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    Dashboard <br>
                    <small>Agregar Nuevo Vehiculo</small>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        
        @include('layouts.messages') 
        
        <div class="card">
            <div class="card-title">
                
                <h1></h1>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('vehicles.store') }}"
                enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="row">
                    <div class="col-md-12">
                                <label>Titulo</label>
                                <input type="text" class="form-control" name="title"
                                    value="{{ old('title') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Patente</label>
                                <input type="text" class="form-control" name="patent"
                                    value="{{ old('patent') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Marca</label>
                                <select name="brand_id" id="brands" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Select..</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ (old("brand") == $brand->id ? "selected":"") }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Modelo</label>
                                <select name="model_id" id="models"
                                    class="form-control select2 js-example-basic-single"> 
                                        <option value="" selected>Seleccione Modelo..</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Version</label>
                                <select name="version_id" id="versions"
                                    class="form-control select2 js-example-basic-single"> 
                                        <option value="" selected>Seleccione Version..</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Kilometraje</label>
                                <input type="number" step="1" class="form-control" name="kilometers"
                                    value="{{ old('kilometers') }}" required>
                            </div>
                            <div class="col-md-1">
                                <label>Año</label>
                                <input type="text" class="form-control" name="year"
                                    value="{{ old('year') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>Combustible</label>
                                <select name="fuel_id" id="fuels" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Seleccione Combustible.</option>
                                    @foreach ($fuels as $fuel)
                                        <option value="{{ $fuel->id }}" {{ (old("fuel") == $fuel->id ? "selected":"") }}>
                                            {{ $fuel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color"
                                    value="{{ old('color') }}" required>
                            </div>
                            <div class="col-md-1">
                                <label>Moneda</label>
                                <select name="currency_id" id="currencies" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Seleccione Moneda</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{ (old("currency") == $currency->id ? "selected":"") }}>
                                            {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Precio</label>
                                <input type="text" class="form-control" name="price"
                                    value="{{ old('price') }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="description"
                                value="{{ old('description') }}">
                        </div>
                        <div class="form-row">
                            <label>Comentarios</label>
                            <input type="text" class="form-control" name="comments"
                                value="{{ old('comments') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Sucursal</label>
                                <select name="location_id" id="locations" class="form-control">
                                    <option value="" selected>Select..</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" {{ (old("location") == $location->id ? "selected":"") }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Estado</label>
                                <select name="status" id="status" class="form-control">
                                    <option
                                        value="activo">Activo</option>
                                    <option
                                        value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Vista</label>
                                <select name="views" id="views" class="form-control">
                                    <option
                                        value="destacado">Destacado</option>
                                    <option
                                        value="normal">Normal</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <label>
                                {{ __('Images') }}
                            </label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" name="images[]" class="form-control"
                                        multiple>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <button type="submit" class="btn btn-primary btn-large mt-3">Agregar Vehículo</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#brands').change(function() {
                var selectedBrand = $(this).val();
                $.ajax({
                    url: "{{ route('vehicle.getModels') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        brand: selectedBrand
                    },
                    success: function(response) {
                        $('#models').html(response);
                        $('#models').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('#models').change(function() {
                var selectedModel = $(this).val();
                $.ajax({
                    url: "{{ route('vehicle.getVersions') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        model: selectedModel
                    },
                    success: function(response) {
                        $('#versions').html(response);
                        $('#versions').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });


    </script>


@endsection
