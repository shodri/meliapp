@extends('adminlte::page')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <small>Editar {{ $vehicle->brand->name }} {{ $vehicle->model->name }}</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-title">

                    <h1></h1>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('vehicles.update', ['vehicle' => $vehicle->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-3">
                                <label>Patente</label>
                                <input type="text" class="form-control" name="patent"
                                    value="{{ old('patent') ?? $vehicle->patent }}">
                            </div>
                            <div class="col-md-3">
                                <label>Marca</label>
                                <select name="brand" id="brands" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Select..</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $selectedBrand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Modelo</label>
                                <select name="model_id" id="models"
                                    class="form-control select2 js-example-basic-single"
                                    {{ !$selectedModel ? 'disabled' : '' }}>

                                    @if ($selectedModel)
                                        @foreach ($models as $model)
                                            <option value="{{ $model->id }}"
                                                {{ $model->id == $selectedModel->id ? 'selected' : '' }}>
                                                {{ $model->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>Select..</option>
                                    @endif

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Version</label>
                                <input type="text" class="form-control" name="version"
                                    value="{{ old('version') ?? $vehicle->version->name }}" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Kilometraje</label>
                                <input type="number" step="1" class="form-control" name="km"
                                    value="{{ old('km') ?? $vehicle->kilometers }}" required>
                            </div>
                            <div class="col-md-1">
                                <label>Año</label>
                                <input type="text" class="form-control" name="year"
                                    value="{{ old('year') ?? $vehicle->year }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>Combustible</label>
                                <input type="text" class="form-control" name="fuel"
                                    value="{{ old('fuel') ?? $vehicle->fuel->name }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Moneda</label>
                                <input type="text" class="form-control" name="currency"
                                    value="{{ old('currency') ?? $vehicle->currency->name }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Precio</label>
                                <input type="text" class="form-control" name="price"
                                    value="{{ old('price') ?? $vehicle->price }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="description"
                                value="{{ old('description') ?? $vehicle->description }}" required>
                        </div>
                        <div class="form-row">
                            <label>Comentarios</label>
                            <input type="text" class="form-control" name="comments"
                                value="{{ old('comments') ?? $vehicle->comments }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Sucursal</label>
                                <select name="location" id="locations" class="form-control">
                                    <option value="" selected>Select..</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ $location->id == $selectedLocation->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Estado</label>
                                <select name="status" id="status" class="form-control">
                                    <option
                                        {{ old('status') == 'activo' ? 'selected' : ($vehicle->status == 'activo' ? 'selected' : '') }}
                                        value="activo">Activo</option>
                                    <option
                                        {{ old('status') == 'inactivo' ? 'selected' : ($vehicle->status == 'inactivo' ? 'selected' : '') }}
                                        value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Vista</label>
                                <select name="views" id="views" class="form-control">
                                    <option
                                        {{ old('status') == 'destacado' ? 'selected' : ($vehicle->status == 'destacado' ? 'selected' : '') }}
                                        value="destacado">Destacado</option>
                                    <option
                                        {{ old('status') == 'normal' ? 'selected' : ($vehicle->status == 'normal' ? 'selected' : '') }}
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
                            <button type="submit" class="btn btn-primary btn-large mt-3">Editar Vehículo</button>
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
        });

    </script>


@endsection
