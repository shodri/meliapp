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
                            <h1>Listado de Banners</h1>
                            <a class="btn btn-success" href="{{ route('banners.create') }}">
                                <i class="fas fa-plus"></i>
                                &nbsp;
                                Crear Nuevo Banner
                            </a>
                        </div>

                        @empty($banners)
                            <div class="alert alert-warning">
                                The list is empty
                            </div>
                        @else
                            <table class="table table-striped table-hover" id="banners-table">
                                @foreach ($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->redirect }}</td>
                                        <td>{{ $banner->status }}</td>
                                        <td>
                                            <a class="btn btn-warning"
                                                href="{{ route('banners.edit', ['banner' => $banner->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                                <form class="d-inline" method="POST"
                                                    action="{{ route('banners.destroy', ['banner' => $banner->id]) }}">
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
            $('#banners-table').DataTable({
                "paging": true, // Habilita la paginación
                "pageLength": 10, // Número de registros por página
                "searching": true,
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
                "columns": [
                    {
                        "data": "title",
                        "title": "Titulo"
                    },
                    {
                        "data": "redirect",
                        "title": "Link redirección"
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
