@extends('layouts.front')
@section('content')
    <!-------- CONENIDO ------->
    <div class="container-fluid">
        <style>
            .item-box-blog {
                border: 1px solid #dadada;
                z-index: 4;
                padding: 0px;
                margin-bottom: 20px;
            }

            .item-box-blog a:link,
            a:visited {
                background-color: #ffffff;
                color: #1e1e1e;
                text-decoration: none;
                display: inline-block;
            }

            .item-box-blog-image {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 175px;
                overflow: hidden;
                margin-bottom: 10px;
                background-color: #dcdcdc;
            }

            .item-box-blog-body {
                padding: 0px 10px 0px 10px;
            }

            .item-box-blog-text {
                height: 40px;
                overflow: hidden;
            }

            .item-box-blog-image figure img {
                width: 100%;
                height: auto;
            }

            figure img {
                width: 300px;
            }
        </style>

        <div class='container'>

            <form class='form' role='form' id='form1' name='form1' method='post' action='{{route('front.usados')}}'>
                @csrf
                <input type='hidden' id='page' name='page' value='1'>

                <div class="row">
                    <div class="col-md-10">
                        <h2><br>Usados <b>en stock</b></h2>
                        <p>Encontrá el tuyo entre nuestro stock disponible.</p>
                    </div>
                    <div class="col-md-2">
                        <br />
                        Ordenar por<br />
                        <select name="orderBy" id="orderBy" class="form-control input-sm">
                            <option value="date">Recientes</option>
                            <option value="1">Menor precio</option>
                            <option value="2">Mayor precio</option>
                            <option value="3">Marca / Modelo</option>
                            <option value="4" selected="selected">Año</option>
                            <option value="5">Menor kilometraje</option>
                        </select>
                    </div>
                </div>
                <br /><br />

                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                Marca<br />
                                    <select name="brand" id="brands" class="form-control input-sm">
                                        <option value="" selected>Seleccione una Marca</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ ($selectedBrand == $brand->id ? "selected":"") }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-md-12">
                                Modelo<br />
                                <select name="model" id="models" class="form-control input-sm">
                                    @if(!is_null($models))
                                        @foreach ($models as $model)
                                            <option value="{{ $model->id }}" {{ ($selectedModel == $model->id ? "selected":"") }}>
                                                {{ $model->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                Año<br />
                                <div class='row'>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm' name='minAnio'
                                            id='minAnio' value='{{ isset($minAnio) ? $minAnio : '' }}' min='2003' max='2023' placeholder='desde'>
                                    </div>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm' name='maxAnio'
                                            id='maxAnio' value='{{ isset($maxAnio) ? $maxAnio : '' }}' min='2003' max='2023' placeholder='hasta'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                Precio<br />
                                <div class='row'>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm'
                                            name='minPrice' id='minPrice' value='{{ isset($minPrice) ? $minPrice : '' }}' min='0'
                                            placeholder='mínimo'></div>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm'
                                            name='maxPrice' id='maxPrice' value='{{ isset($maxPrice) ? $maxPrice : '' }}' min='0'
                                            placeholder='máximo'></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                Kilometraje<br />
                                <div class='row'>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm'
                                            name='minKms' id='minKms' value='{{ isset($minKms) ? $minKms : '' }}' min='0'
                                            placeholder='mínimo'></div>
                                    <div class='col-md-6'><input type='number' class='form-control input-sm'
                                            name='maxKms' id='maxKms' value='{{ isset($maxKms) ? $maxKms : '' }}' min='0'
                                            placeholder='máximo'></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br /><input type="submit" id="buscar" name="buscar" class="btn btn-cta btn-block"
                                    value="Buscar">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($vehicles as $vehicle)
                                <div class="col-md-4" style="padding:5px !important;">
                                    <div class="item-box-blog">
                                        <a href="{{ route('front.usado', ['vehicle' => $vehicle->id]) }}" tabindex="0">
                                            <div class="item-box-blog-image">
                                                <figure><img alt="" src="{{ (!is_null($vehicle->images->first()) && !is_null($vehicle->images->first()->path)) ? $vehicle->images->first()->path : asset('front/images/usado-default.jpg') }}">
                                                </figure>

                                            </div>
                                            <div class="item-box-blog-body">
                                                <div class="item-box-blog-heading">
                                                    <h4>$&nbsp;{{ number_format($vehicle->price, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="item-box-blog-data">
                                                    <div class="item-box-blog-text">
                                                        <p><b>{{ $vehicle->brand->name }} {{ $vehicle->model->name }}
                                                                {{ $vehicle->version->name }}</b>
                                                            <!--br><small><span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;"></span></p></small-->
                                                    </div>
                                                    <p>{{ $vehicle->kilometers }} | {{ $vehicle->year }} | <small>
                                                            ({{ $vehicle->images->count() }} Fotos)</small></p>
                                                </div>

                                                <div class="item-box-location">
                                                    <span class="fas fa-map-marker-alt"
                                                        style="font-size: 12px; color:#8c8c8c;"></span><small>{{ $vehicle->location->city }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- <div class="row">
                            <ul class="pagination">
                                <li class='active'><a class='pagBtn' data-page='1'>1</a></li>
                                <li class=''><a class='pagBtn' data-page='2'>2</a></li>
                                <li class=''><a class='pagBtn' data-page='3'>3</a></li>
                            </ul>
                        </div> --}}


                    </div>


                </div>
            </form>
        </div>


<!--*************auxiliares*****************-->

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


            $("#orderBy").change(function(e) {
                $('#form1').submit();
            });

            loadModelos();

            $("#buscar").click(function() {
                $('#page').val(1);
                $('#form1').submit();
            });

            $(".pagBtn").click(function() {
                var p = $(this).attr('data-page');
                //console.log('page:'+p);
                $('#page').val(p);
                $('#form1').submit();
            });
            
        </script>
    </div>
     
  
@endsection
