@extends('layouts.front')
@section('content')
    <!-- IN INDEX -->
	<style>
		.image-responsive {
			max-width: 100%; /* La imagen no superará el ancho del contenedor */
			height: auto; /* La altura se ajustará automáticamente para mantener la proporción original */
			display: block; /* Elimina el espacio en blanco debajo de la imagen */
		}
	</style>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $banner)
                <div class="item {{ $loop->first ? 'active' : '' }}">
                    <img class="hidden-xs hidden-sm"
                        src='{{($banner->images->first(function ($image) { return $image->screen === "lg"; })) ? asset($banner->images->first(function ($image) { return $image->screen === "lg"; })->path) : ""}}'
                        style="width:100%" alt="">
                    <img class="hidden-md hidden-lg"
                        src="{{($banner->images->first(function ($image) { return $image->screen === "sm"; })) ? asset($banner->images->first(function ($image) { return $image->screen === "sm"; })->path) : ""}}"
                        style="width:100%" data-src="" alt="">

                </div>
            @endforeach          

        </div>

        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span><img src="{{asset('front/images/arrow-l.png')}}"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span><img src="{{asset('front/images/arrow-r.png')}}"></span>
        </a>
    </div>

    <div class="container">

        <!-- IN SEARCH -->
        <div class="search_home">
            <h3 class="text-center"><b>BUSCÁ TU USADO</b></h3>
            <form class='form' role='form' id='form1' name='form1' method='post' action='{{route('front.usados')}}'>
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label><b>MARCA</b></label>
						<select name="brand" id="brands" class="form-control search-slt">
							<option value="" selected>Seleccione una Marca</option>
							@foreach ($brands as $brand)
								<option value="{{ $brand->id }}" {{ (old("brand") == $brand->id ? "selected":"") }}>
									{{ $brand->name }}
								</option>
							@endforeach
						</select>
                    </div>
                    <div class="col-md-3">
                        <label><b>MODELO</b></label>
                        <select name="model" id="models" class="form-control search-slt"></select>
                    </div>
                    <div class="col-md-3">
                        <label><b>PRECIO MÁXIMO</b></label>
                        <input type="text" class="form-control search-slt" name="maxPrice" id="maxPrice" value="">
                    </div>
                    <div class="col-md-3">
                        <input type="submit" name="buscar" style="width:100%; margin-top:22px;" class="btn btn-cta"
                            value="Buscar">
                    </div>
                </div>
            </form>
        </div>
        <!-- OUT SEARCH -->





        <div class="row">
            <div class="col-sm-12" style="text-align:center;"><br><br>
                <h1><img src="http://escobarusados.cerbero.ultrait.com.ar/_red/escobarusados/userfiles/images/destacado.png"
                        width="60"> Usados <b>Destacados!</b></h1>
            </div>
        </div>

        <div class="row">
			@foreach($vehicles as $vehicle)
				<div class="col-md-3" style="padding:5px !important;">
					<div class="item-box-blog">
						<a href="{{ route('front.usado', ['vehicle' => $vehicle->id] )}}"
							tabindex="0" style="outline: none; width:100%;">
							<div class="item-box-blog-image">
								<figure>
									<img alt="" class="image-responsive" src="{{ $vehicle->images->first()->path }}">
								</figure>
							</div>
							<div class="item-box-blog-body">
								<div class="item-box-blog-date bg-blue-ui white"><img
										src="http://escobarusados.cerbero.ultrait.com.ar/_red/escobarusados/userfiles/images/destacado.png"
										width="40">
								</div>
								<div class="item-box-blog-heading">
									<h4>$&nbsp;{{$vehicle->price}} </h4>
								</div>
								<div class="item-box-blog-data">
									<div class="item-box-blog-text">
										<p><b>{{$vehicle->brand->name}} {{$vehicle->model->name}} <br>{{$vehicle->version->name}} </b>
											<!--br><small><span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;"></span></p></small-->
									</div>
									<p>{{$vehicle->kilometers}} | {{$vehicle->year}} | <small> ({{$vehicle->images->count()}} Fotos)</small></p>
								</div>

								<div class="item-box-location">
									<span class="fas fa-map-marker-alt"
										style="font-size: 12px; color:#8c8c8c;"></span><small>{{$vehicle->location->city}}</small>
								</div>
							</div>
						</a>
					</div>
				</div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-sm-12" style="text-align:center;">
                <a href="/usados/seleccion/especial" class="btn btn-cta">Ver todos los destacados</a>
            </div>
        </div>












        <div class="row">
            <div class="col-sm-12" style="text-align:center;">
                <br><br>
                <h2>Acerca de ESCOBAR</h2>
                <h4>Descubrí nuestros servicios</h4>

            </div>
        </div>
    </div>
    <br><br>


    <div class="container"><br>

        <div class='row'>
            <div class="col-md-4">
                <a
                    href='#'>
                    <img src="{{asset('front/images/bc1.jpg')}}"
                        width="100%" alt="SHOWROOM">
                </a> <br><br>
                <h4 class="life"><b>SHOWROOM</b></h4>
                <p>Vení a conocer tu próximo modelo en nuestro exclusivo showroom</p>
            </div>
            <div class="col-md-4">
                <a href='#'> <img
                        src="{{asset('front/images/bc2.jpg')}}"
                        width="100%" alt="CONOCENOS">
                </a> <br><br>
                <h4 class="life"><b>CONOCENOS</b></h4>
                <p>Sobre nuestra empresa...</p>
            </div>
            <div class="col-md-4">
                <a href='#'> <img
                        src="{{asset('front/images/bc3.jpg')}}"
                        width="100%" alt="CONTACTANOS">
                </a> <br><br>
                <h4 class="life"><b>CONTACTANOS</b></h4>
                <p>¿Tenés dudas? Ponete en contacto con nosotros.</p>
            </div>
        </div>
        <hr>
    </div>

    <div style="background-color:#e5e5e5; padding-top:10px; padding-bottom:10px;">
        <div class="container">
            <div class="row">
                <div class="col-md-2"><img
                        src="{{ asset('front/images/logo_top.png') }}"
                        width="200"></a></div>
                <div class="col-md-10"><br />

                    @foreach ($locations as $location)
                        <b>{{$location->province}}</b> | {{$location->address}} - {{$location->city}} ({{$location->province}}) | {{$location->telephone}}<br /><b>Viaweb
                    @endforeach

                    
                </div>
            </div>
        </div>
    </div>

    <!-- IN MAIN CONTENT -->


    <style>
        select {
            width: 100%;
            padding: 16px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>


    <!-- IN MODAL -->
    <div class="modal fade" id="WhatsappModal" tabindex="-1" role="dialog" aria-labelledby="WhatsappModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="padding:20px;">
                    <div data-dismiss="modal" aria-label="Close" style="position:absolute;top:0px;right:0px;"><img
                            src="http://escobarusados.cerbero.ultrait.com.ar/_red/_usados1/_images/close.png"></div>

                    <div class="row">
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <img src="http://escobarusados.cerbero.ultrait.com.ar/_images/wa.jpg" width="80%"><br />
                        </div>
                        <div class="col-md-10 text-left">
                            <h4><b>Nuestros WHATSAPP</b><br>Seleccione el motivo de su contacto</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center"><br />
                            <div id="faq" role="tablist" aria-multiselectable="true">
                                <a class="btn btn-cta btn-sm" style="width:100%; margin-bottom:5px;"
                                    data-toggle="collapse" data-parent="#faq" href="#a_us" aria-expanded="false"
                                    aria-controls="a_us">
                                    Usados </a>
                                <div id="a_us" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="questionOne">
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493425346064&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Santa Fe <b>5493425346064</b></a>
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=3492250025&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Rafaela <b>3492250025</b></a>
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493434715332&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Paraná <b>5493434715332</b></a>
                                </div>
                                <a class="btn btn-cta btn-sm" style="width:100%; margin-bottom:5px;"
                                    data-toggle="collapse" data-parent="#faq" href="#a_acv" aria-expanded="false"
                                    aria-controls="a_acv">
                                    Administración </a>
                                <div id="a_acv" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="questionOne">
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493424791292&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Santa Fe <b>5493424791292</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

    <div id="overlay-wa">
        <a href="#" data-toggle="modal" data-show="true" data-target="#WhatsappModal"
            data-remote-target="#WhatsappModal .modal-body">
            <img src="http://escobarusados.cerbero.ultrait.com.ar/_red/_usados1/_images/wa.png">
        </a>
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
    </div>
    <!------ / CONENIDO ------->



    <style>
        select {
            width: 100%;
            padding: 16px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>


    <!-- IN MODAL -->
    <div class="modal fade" id="WhatsappModal" tabindex="-1" role="dialog" aria-labelledby="WhatsappModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="padding:20px;">
                    <div data-dismiss="modal" aria-label="Close" style="position:absolute;top:0px;right:0px;"><img
                            src="http://escobarusados.cerbero.ultrait.com.ar/_red/_usados1/_images/close.png"></div>

                    <div class="row">
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <img src="http://escobarusados.cerbero.ultrait.com.ar/_images/wa.jpg" width="80%"><br />
                        </div>
                        <div class="col-md-10 text-left">
                            <h4><b>Nuestros WHATSAPP</b><br>Seleccione el motivo de su contacto</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center"><br />
                            <div id="faq" role="tablist" aria-multiselectable="true">
                                <a class="btn btn-cta btn-sm" style="width:100%; margin-bottom:5px;"
                                    data-toggle="collapse" data-parent="#faq" href="#a_us" aria-expanded="false"
                                    aria-controls="a_us">
                                    Usados </a>
                                <div id="a_us" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="questionOne">
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493425346064&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Santa Fe <b>5493425346064</b></a>
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=3492250025&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Rafaela <b>3492250025</b></a>
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493434715332&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Paraná <b>5493434715332</b></a>
                                </div>
                                <a class="btn btn-cta btn-sm" style="width:100%; margin-bottom:5px;"
                                    data-toggle="collapse" data-parent="#faq" href="#a_acv" aria-expanded="false"
                                    aria-controls="a_acv">
                                    Administración </a>
                                <div id="a_acv" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="questionOne">
                                    <a class="btn btn-default btn-sm" style="width:100%; margin-bottom:10px;"
                                        href="https://api.whatsapp.com/send?phone=5493424791292&amp;text=Quisiera realizar una consulta."
                                        target="_blank">Santa Fe <b>5493424791292</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

    <div id="overlay-wa">
        <a href="#" data-toggle="modal" data-show="true" data-target="#WhatsappModal"
            data-remote-target="#WhatsappModal .modal-body">
            <img src="http://escobarusados.cerbero.ultrait.com.ar/_red/_usados1/_images/wa.png">
        </a>
    </div>
@endsection
