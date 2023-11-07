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
                            <h1>Notificaciones Recientes</h1>
                            {{-- <a class="btn btn-success" href="#">
                                <i class="fas fa-plus"></i>
                                &nbsp;
                                Crear Nuevo Vehículo
                            </a> --}}
                        </div>

                        @empty($questions)
                            <div class="alert alert-warning">
                                The list is empty
                            </div>
                        @else
                            <table class="table table-striped table-hover" id="questions-table">
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ $question->interval }}</td>
                                        <td>{{ $question->vehicle->brand->name }} {{ $question->vehicle->model->name }} {{ $question->vehicle->version->name }} {{ $question->vehicle->year }} ${{ $question->vehicle->price }} ({{ $question->vehicle->meli_id }}) </td>
                                        <td>{{ $question->vehicle->meli_link }}</td>
                                        <td>{{ $question->text }}</td>
                                        <td>{{ $question->status }}</td>
                                        <td>
                                            <a class="btn btn-warning"
                                                href="{{ route('notifications.question', ['question' => $question->id]) }}">
                                                <i class="fas fa-reply"></i>
                                            </a>

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
            $('#questions-table').DataTable({
                "paging": true, // Habilita la paginación
                "pageLength": 10, // Número de registros por página
                "searching": true,
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
                "columns": [{
                        "data": "interval",
                        "title": "Fecha"
                    },
                    {
                        "data": "item_id",
                        "title": "Vehiculo"
                    },
                    {
                        "data": "text",
                        "title": "Texto"
                    },
                    {
                        "data": "link",
                        "title": "Link"
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
