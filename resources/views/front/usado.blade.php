@extends('layouts.front')
@section('content')
<!-------- CONENIDO ------->
<div class="container-fluid">
    <style>
        td {
            font-size: 11px;
        }
    </style>


    <div class="container">


        <div class="row">

            <div class="col-md-6">
                <br />
                <div class="carousel slide" id="slidemodelos">
                    <div class="carousel-inner">
                        @foreach($vehicle->images as $image)
                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{$image->path}}"
                                    width="100%">
                            </div>
                        @endforeach                       
                    </div>
                    <a class="left carousel-control" href="#slidemodelos" data-slide="prev">
                        <span><img src="/_red/_ford/_images/arrow-l.png"></span>
                    </a>
                    <a class="right carousel-control" href="#slidemodelos" data-slide="next">
                        <span><img src="/_red/_ford/_images/arrow-r.png"></span>
                    </a>
                </div>
            </div>

            <div class="col-md-3">

                <h3>{{$vehicle->title}} </h3>
                <h4>Año: <b>{{$vehicle->year}}</b> / Kms: <b>{{$vehicle->kilometers}}</b></h4>
                <h2 class="text-center"><b>
                        $ {{ number_format($vehicle->price, 0, ',', '.') }} </b>
                </h2>

                <span>
                    <br />Combustible: <b>{{$vehicle->fuel->name}}</b>
                    <br />Ubicación: <b>{{$vehicle->location->name}}</b>
                    <br />Marca: {{$vehicle->brand->name}} <br />Modelo: {{$vehicle->model->name}} <br />Versión: {{$vehicle->version->name}}
                    <br />Segmento: {{$vehicle->segment->name ?? ''}}<br />Color: {{$vehicle->color}}<br />Comentarios: <br />Forma de pago: A convenir <br />Ubicación:
                    {{$vehicle->location->province}} - {{$vehicle->location->city}}<br />{{$vehicle->location->address}}<br />{{$vehicle->location->telephone}} </span>

            </div>

            <div class="col-md-3">
                <br />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>SOLICITAR MÁS INFORMACIÓN</b>
                    </div>
                </div>
                <form method="post" action="">
                    <input type="hidden" name="id" value="2465">


                    <input placeholder="Nombre" class='form-control' type="text" name="nombre" value=""
                        style="width:100%; margin-top:5px;">
                    <input placeholder="Apellido" class='form-control' type="text" name="apellido" value=""
                        style="width:100%; margin-top:5px;">
                    <input placeholder="Teléfono" class='form-control' type="text" name="telefono" value=""
                        style="width:100%; margin-top:5px;"> <input placeholder="Email" class='form-control'
                        type="text" name="email" value="" style="width:100%; margin-top:5px;"> <input
                        placeholder="Horario de contacto" class='form-control' type="text" name="horario"
                        value="" style="width:100%; margin-top:5px;">
                    <textarea placeholder="Comentarios" class='form-control' name="mensaje" rows="4" maxLength='800'
                        style="margin-top:5px;"></textarea>

                    <div class='row'>
                        <div class="col-md-12" style="padding-top:15px;">
                            <div class="g-recaptcha"
                                data-sitekey="6LdLD6sUAAAAAKxLj7aZavlFLN2StNCjVJIi2BoW "style="transform:scale(0.9);transform-origin:0;-webkit-transform:scale(0.9); transform:scale(0.9);-webkit-transform-origin:0 0;transform-origin:0 0;">
                            </div>
                            <p><button class="btn btn-cta" type="submit" style="width:100%;">Enviar solicitud</button>
                            </p>
                        </div>
                    </div>
                </form>

            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <hr>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>USADOS SIMILARES EN PRECIO</b>
                    </div>
                </div>
                <TABLE class="table table-bordered">
                    <TR>
                        <TD><b>Marca y Modelo</b></TD>
                        <TD><b>Año</b></TD>
                        <TD style='text-align:right;padding-right:20px'><b>Kilometraje</b></TD>
                        <TD><b>Precio</b></TD>
                    </TR>
                    @foreach($similarPrice as $similar)
                        <TR class='vLink' data-id='{{$vehicle->id}}'
                        data-url='{{route('front.usado', ['vehicle' => $vehicle->id])}}'
                        onmouseover='this.bgColor="#dddddd"' onmouseout='this.bgColor=""' style='cursor:pointer;'>
                        <TD>{{$vehicle->brand->name}} {{$vehicle->model->name}}</TD>
                        <TD>{{$vehicle->year}}</TD>
                        <TD style='text-align:right;padding-right:20px'>{{$vehicle->kilometers}}</TD>
                        <TD>$ {{ number_format($vehicle->price, 0, ',', '.') }}</TD>
                        </TR>
                    @endforeach                   
                </TABLE>
            </div>
            <div class="col-md-6">
                <hr>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>USADOS SIMILARES EN MODELO</b>
                    </div>
                </div>
                <TABLE class="table table-bordered">
                    <TR>
                        <TD><b>Marca y Modelo</b></TD>
                        <TD><b>Año</b></TD>
                        <TD style='text-align:right;padding-right:20px'><b>Kilometraje</b></TD>
                        <TD><b>Precio</b></TD>
                    </TR>
                </TABLE>

            </div>
        </div>


    </div>

    <script type="text/javascript">
        function showImage() {
            //console.log('showImage');
            //$("#main_img").attr('src', $(this).attr('src') + '?w=400&h=333');	
            $("#main_img").attr('src', $(this).attr('src'));

        }
        window.onload = function() {
            $(".list_img").mouseover(showImage);
            $(".list_img").click(showImage);
            $(".vLink").click(function() {
                var url = $(this).attr('data-url');
                if (typeof url !== "undefined" && url != '')
                    document.location.href = url;
            });
        }
        //-->
    </script>

</div>
<!------ / CONENIDO ------->
@endsection
