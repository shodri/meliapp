@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
    <div class="container">
        <div class="row">
            
            @if (session()->has('success'))
                <br>
                <div class="col-md-12">
                    <div class="alert alert-success mt-2">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif

            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h1>Listado de Vehiculos {{$condition}}</h1>
                            <a class="btn btn-success" href="{{ route('vehicles.create') }}">
                                <i class="fas fa-plus"></i>
                                &nbsp;
                                Crear Nuevo Vehículo
                            </a>
                        </div>

                        @empty($vehicles)
                            <div class="alert alert-warning">
                                The list is empty
                            </div>
                        @else
                            <table class="table table-striped table-hover" id="vehicles-table">
                                @foreach ($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->year }}</td>
                                        <td>{{ $vehicle->brand->name }}</td>
                                        <td>{{ $vehicle->model->name }}</td>
                                        <td>{{ (isset($vehicle->version->name)) ? $vehicle->version->name : '' }}</td>
                                        <td>{{ $vehicle->location->address }}</td>
                                        <td>${{ number_format($vehicle->price, 0, ',', '.') }}.-</td>
                                        <td>{{ ($vehicle->meli_id == "") ? "No" : "Si" }}</td>
                                        <td>
                                            <a class="btn btn-warning"
                                                href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @if($vehicle->meli_id == "")
                                                <a class="btn btn-success"
                                                    href="{{ route('vehicles.publish', ['vehicle' => $vehicle->id]) }}">
                                                    <i class="fas fa-upload"></i>
                                                </a>
                                                <form class="d-inline" method="POST"
                                                    action="{{ route('vehicles.destroy', ['vehicle' => $vehicle->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endempty
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>







            </div>
        </div>
    </div>

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#vehicles-table').DataTable({
                "paging": true, // Habilita la paginación
                "pageLength": 10, // Número de registros por página
                "searching": true,
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
                "columns": [{
                        "data": "year",
                        "title": "Año"
                    },
                    {
                        "data": "brand",
                        "title": "Marca"
                    },
                    {
                        "data": "model",
                        "title": "Modelo"
                    },
                    {
                        "data": "version",
                        "title": "Version"
                    },
                    {
                        "data": "location",
                        "title": "Sucursal"
                    },
                    {
                        "data": "price",
                        "title": "Precio"
                    },
                    {
                        "data": "sync",
                        "title": "Sync"
                    },
                    {
                        "data": "actions",
                        "title": "Acciones"
                    },
                ],
            });
        });
    </script>
@stop
@endsection
