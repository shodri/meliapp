@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12 mt-2">
                
                @include('layouts.messages') 

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <h1>Responder pregunta</h1>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pregunta</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: block;">
                                    {{ $question->text }}
                                </div>
                            </div>
                        </div>


                        <form method="POST" action="{{ route('meli.answer', ['question' => $question->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12 ml-4">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Responder</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                    class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0" style="display: block;">
                                        <div class="form-group">
                                            <textarea name="answer" class="form-control" rows="3" placeholder="Ingrese aquí una respuesta" required></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-paper-plane"></i>
                                                &nbsp;
                                                Enviar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection
