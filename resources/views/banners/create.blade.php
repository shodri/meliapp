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
                        <small>Agregar Nuevo Banner</small>
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
                    <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="col-md-12">
                                <label>Titulo</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>

                            <div class="col-md-12">
                                <label>Link al que redirecciona</label>
                                <input type="text" class="form-control" name="redirect" value="{{ old('redirect') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Estado</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Vista</label>
                                <select name="views" id="views" class="form-control">
                                    <option value="destacado">Destacado</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>

                        </div>

                        <br>
                        <div class="row">

                            <label>
                                {{ __('Imagen Mobile') }}
                            </label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" name="image_sm" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <label>
                                {{ __('Imagen Desktop') }}
                            </label>
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" name="image_lg" class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <button type="submit" class="btn btn-primary btn-large mt-3">Agregar Banner</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
