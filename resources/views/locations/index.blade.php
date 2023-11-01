@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="d-flex justify-content-between align-items-center">
                    <h1>Sucursales</h1>
                    {{-- <a class="btn btn-success" href="{{ route('locations.create') }}">
                        <i class="bi bi-plus"></i> 
                        Crear Nueva Sucursal
                    </a> --}}
                </div>

                @empty($locations)
                    <div class="alert alert-warning">
                        The list is empty
                    </div>
                @else
                    <table class="table table-striped table-hover" id="locations-table">
                        @foreach ($locations as $location)
                            <tr>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td>{{ $location->city }}</td>
                                <td>{{ $location->province }}</td>
                                <td>{{ $location->status }}</td>
                                <td>
                                    <a class="btn btn-warning"
                                    href="{{ route('locations.edit', ['location' => $location->id]) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form class="d-inline" method="POST"
                                        action="{{ route('locations.destroy', ['location' => $location->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endempty


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
            $('#locations-table').DataTable({
                "ajax": false,
                "paging": true, // Habilita la paginación
                "pageLength": 10, // Número de registros por página
                "searching": true,
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
                "columns": [
                    {
                        "data": "name",
                        "title": "Nombre"
                    },
                    {
                        "data": "address",
                        "title": "Dirección"
                    },
                    {
                        "data": "city",
                        "title": "Ciudad"
                    },
                    {
                        "data": "province",
                        "title": "Provincia"
                    },
                    {
                        "data": "status",
                        "title": "Estado"
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
