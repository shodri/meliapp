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
                    <form method="POST" action="{{ route('vehicles.update', ['vehicle' => $vehicle->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <label>Titulo</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>

                            <div class="col-md-3">
                                <label>Patente</label>
                                <input type="text" class="form-control" name="license_plate"
                                    value="{{ old('license_plate') ?? $vehicle->license_plate }}">
                            </div>
                            <div class="col-md-3">
                                <label>Marca</label>
                                <select name="brand" id="brands" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Seleccione Marca..</option>
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
                                    value="{{ old('version') ?? isset($vehicle->version->name) }}" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Kilometraje</label>
                                <input type="number" step="1" class="form-control" name="kilometers"
                                    value="{{ old('kilometers') ?? $vehicle->kilometers }}" required>
                            </div>
                            <div class="col-md-1">
                                <label>Año</label>
                                <input type="text" class="form-control" name="year"
                                    value="{{ old('year') ?? $vehicle->year }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>Combustible</label>
                                <select name="fuel_id" id="fuels" class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Seleccione Combustible.</option>
                                    @foreach ($fuels as $fuel)
                                        <option value="{{ $fuel->id }}"
                                            {{ old('fuel') == $fuel->id ? 'selected' : '' }}>
                                            {{ $fuel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color" value="{{ old('color') }}"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label>Moneda</label>
                                <select name="currency_id" id="currencies"
                                    class="form-control select2 js-example-basic-single">
                                    <option value="" selected>Seleccione Moneda</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ old('currency') == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                {{ __('Imagenes') }}
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

                        <a class="btn btn-warning"
                            href="{{ route('meli.pausePublication', ['vehicle' => $vehicle->id]) }}">
                            <i class="fas fa-pause"></i>
                            Pausar Publicación
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">

            <div class="card card-secondary">
                <div class="card-header">
                <h3 class="card-title">Atributos</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus mt-2"></i>
                </button>
                </div>
                
                </div>
                
                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Motor</label>
                            <input type="text" class="form-control" name="motor" value="{{ old('motor') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Puertas</label>
                            <input type="number" class="form-control" name="puertas" value="{{ old('puertas') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Dirección</label>
                            <select name="direccion" id="views" class="form-control">
                                <option value="Manual">Manual</option>
                                <option value="Hidráulica">Hidráulica</option>
                                <option value="Eléctrica">Eléctrica</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Tracción</label>
                            <select name="traccion" id="views" class="form-control">
                                <option value="Delantera">Delantera</option>
                                <option value="Trasera">Trasera</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="HAS_ABS_BRAKES"
                                id="HAS_ABS_BRAKES" name="attributes[]">
                            <label for="HAS_ABS_BRAKES" class="custom-control-label">Tiene ABS</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="HAS_AIR_CONDITIONING"
                                id="HAS_AIR_CONDITIONING" name="attributes[]">
                            <label for="HAS_AIR_CONDITIONING" class="custom-control-label">Tiene Aire Acondicionado</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="HAS_DRIVER_AIRBAG"
                                id="HAS_DRIVER_AIRBAG" name="attributes[]">
                            <label for="HAS_DRIVER_AIRBAG" class="custom-control-label">Tiene Airbag</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="HAS_AMFM_RADIO"
                                id="HAS_AMFM_RADIO" name="attributes[]">
                            <label for="HAS_AMFM_RADIO" class="custom-control-label">Tiene Radio</label>
                        </div>
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
