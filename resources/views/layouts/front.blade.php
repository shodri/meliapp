<!DOCTYPE html>
<html lang="es">

<head>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('front/images/favicon.ico') }}"" type="image/png" />
    <meta http-equiv="Cache-control" content="public">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="{{ asset('front/_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/_css/terminal.css') }}" rel="stylesheet">

    <script src="{{ asset('front/_js/_ultraitFunctions.js') }}"></script>
    <script src="{{ asset('front/_js/uit.min.js') }}"></script>
    
    @include('layouts.js') 

</head>

<body>
    <!------ HEADER ------->
    <div class="container-fluid">
        <nav class="navbar navbar-principal">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#mainmenu-navbar">
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </button>
                    <a href="/"><img src="{{ asset('front/images/logo_top.png') }}" height="70"
                            class="hidden-xs hidden-sm">
                        <img src="{{ asset('front/images/logo_top.png') }}" width="220"
                            class="hidden-md hidden-lg"></a>
                </div>
                <div class="navbar-collapse collapse" id="mainmenu-navbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="http://escobarusados.cerbero.ultrait.com.ar/usados/seleccion/especial">USADOS
                                DESTACADOS</a>
                        </li>
                        <li>
                            <a href="{{route('front.usados')}}">USADOS</a>
                        </li>
                        <li class="dropdown dropdown-large">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">QUIENES SOMOS</a>
                            <ul class="dropdown-menu dropdown-menu-large">
                                <div class="container"><br>
                                    <h3 class="hidden-xs">QUIENES SOMOS
                                        <hr>
                                    </h3>
                                    <p class="sublink"><a
                                            href="{{route('front.empresa')}}">NUESTRA
                                            EMPRESA</a></p>
                                    <p class="sublink"><a
                                            href="http://escobarusados.cerbero.ultrait.com.ar/conozcanos/gestoria">GESTORÍA</a>
                                    </p>
                                    <p class="sublink"><a
                                            href="http://escobarusados.cerbero.ultrait.com.ar/contacto/motivo">CONTACTENOS</a>
                                    </p>
                                    <p class="sublink"><a
                                            href="http://escobarusados.cerbero.ultrait.com.ar/sucursales">SUCURSALES</a>
                                    </p>
                                    <br><br><br>
                                </div>
                            </ul>
                        </li>
                        <li>
                            <a href="http://escobarusados.cerbero.ultrait.com.ar/contacto/motivo">CONTÁCTENOS</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <img src="{{ asset('front/images/grupo.gif') }}"
                            width="300" class="hidden-sm hidden-xs">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!------ / HEADER ------->


    <!-------- CONENIDO ------->
    <div class="container-fluid">
        @yield('content')
    </div>
    <!------ / CONENIDO ------->

    <!---- BOTTOM ---->
    <div class="container-fluid">
        <div style="background-color:#252525;">
            <br />
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="life blanc">Nuestras Ofertas</h4>
                        <a class="foolink" href="/usados/seleccion/especial">Usados Destacados</a>
                        <br /><a class="foolink" href="/usados">Stock de Usados</a>
                    </div>
                    <div class="col-md-3">
                        <h4 class="life blanc">Conózcanos</h4>
                        <a class="foolink" href="/conozcanos/nuestra_empresa">Quienes Somos</a>
                        <br /><a class="foolink" href="/contacto/motivo">Contáctenos</a>
                    </div>
                    <div class="col-md-3">
                        <h4 class="life blanc">Servicios</h4>

                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <br /><br />
            </div>
        </div>
        <br />
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5><small>El contenido de este sitio web no debe ser considerado una oferta y puede ser actualizado
                            en forma total o parcial sin previo aviso y sin incurrir en ninguna obligación. Fotos no
                            contractuales. Las imágenes publicadas en este sitio son de carácter ilustrativo. Consulte
                            equipamientos y especificaciones técnicas con nuestros asesores. </small></h5>
                    <a href="http://www.ultrait.com.ar/" target="_blank">
                        <img src="{{ asset('front/images/viaweb_foot.png') }}"></a><br /><br /><br />
                </div>
            </div>
        </div>
        <!---- / BOTTOM ----><!-- IN MODAL -->
        <div class="modal fade" id="ExModal" tabindex="-1" role="dialog" aria-labelledby="ExModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
</body>


<script src="{{ asset('front/_js/jquery.min.js') }}"></script>
<script src="{{ asset('front/_js/bootstrap.min.js') }}"></script>


<link type="text/css" rel="stylesheet" href="https://escobarusados.cerbero.ultrait.com.ar/public/css/dataTables.bootstrap.min.css" />
 
<script type="text/javascript" src="https://escobarusados.cerbero.ultrait.com.ar/public/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://escobarusados.cerbero.ultrait.com.ar/public/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).on('click.bs.dropdown.data-api', '.dropdown.keep-inside-clicks-open', function(e) {
        e.stopPropagation();
    });
</script>


<script type="text/javascript">
    $('[data-load-remote]').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var remote = $this.data('load-remote');
        if (remote) {
            $($this.data('remote-target')).load(remote);
        }
    });


    (function() {
        // Create jQuery body object
        var $body = $('body'),

            // Use a tags with 'class="modalTrigger"' as the triggers
            $modalTriggers = $('a.modalTrigger'),

            // Trigger event handler
            openModal = function(evt) {
                var $trigger = $(this), // Trigger jQuery object

                    modalPath = $trigger.attr('href'), // Modal path is href of trigger

                    $newModal, // Declare modal variable

                    removeModal = function(evt) { // Remove modal handler
                        $newModal.off('hidden.bs.modal'); // Turn off 'hide' event
                        $newModal.remove(); // Remove modal from DOM
                    },

                    showModal = function(data) { // Ajax complete event handler
                        $body.append(data); // Add to DOM
                        $newModal = $('.modal').last(); // Modal jQuery object
                        $newModal.modal('show'); // Showtime!
                        $newModal.on('hidden.bs.modal', removeModal); // Remove modal from DOM on hide
                    };

                $.get(modalPath, showModal); // Ajax request

                evt.preventDefault(); // Prevent default a tag behavior
            };

        $modalTriggers.on('click', openModal); // Add event handlers
    }());

    $("#myModal").on('hidden.bs.modal', function() {
        $(this).data('bs.modal', null);
    });
</script>

</html>
