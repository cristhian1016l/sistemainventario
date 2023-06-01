@extends('layouts.app')
@section('title', 'Noticias')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')
    @role('admin')
    <div class="row mb-3">
        <div class="col-sm-12 mb-3">
            <h5 class="mb-3">Noticias y Ayuda</h5>
            <hr>
            <a class="btn mb-1 btn-primary collapsed" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">¿A que tengo acceso?</a>
            <button class="btn mb-1 btn-primary collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Que reportes puedo generar</button>
            <button class="btn mb-1 btn-primary collapsed" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Mostrar u ocultar ayuda</button>
            <div class="row">
                <div class="col-sm-6">
                    <div class="multi-collapse mt-2 collapse" id="multiCollapseExample1" style="">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">Como administrador tienes acceso a todos los módulos que son: inventario, RR.HH, Solicitudes, equipos y panel de control (administrador).</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="multi-collapse mt-2 collapse" id="multiCollapseExample2" style="">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">Puedes generar reportes de productos, solicitudes, declaración jurada por áreas y un listado de trabajadores por cargos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    @endrole

    @role('assistance')       
    <div class="row mb-3">
        <div class="col-sm-12 mb-3">
            <h5 class="mb-3">Noticias y Ayuda</h5>
            <hr>
            <a class="btn mb-1 btn-primary collapsed" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">¿A que tengo acceso?</a>
            <button class="btn mb-1 btn-primary collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">¿Cómo creo una solicitud?</button>
            <button class="btn mb-1 btn-primary collapsed" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Ver u ocultar ayuda</button>
            <div class="row">
                <div class="col-sm-6">
                    <div class="multi-collapse mt-2 collapse" id="multiCollapseExample1" style="">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">Tiene acceso a todo el módulo de solicitudes, puedes crear, eliminar, descargar en PDF alguna solicitud, etc..</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="multi-collapse mt-2 collapse" id="multiCollapseExample2" style="">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">Dirígase al menú de "solicitudes", dar click en el botón de crear solicitudes y selecciona el productor,
                                    fecha de entrega y devolución de la solicitud, los productos que se solicita y la cantidad, luego de eso dar
                                    click en crear, a continuación el sistema creará un PDF.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    @endrole

@endsection

@section('js')

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script> -->
<script>
   $(function () {
    var url = window.location;
    // for single sidebar menu
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    }).addClass('active');

    // for sidebar menu and treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open').prev('a')
        .addClass('active');        
  });
</script>
@endsection