<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Trabajadores')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
<link href="{{ asset('css/plugins/daterangepicker.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/plugins/select2.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->

<!-- MENSAJES DE ERROR -->    
<div class="alert alert-danger" style="display:none" id="error"></div>
<!-- TERMINO DE MENSAJES DE ERROR -->

<div class="row">
    <div class="col-md-12" style="display: none" id="reports">
        <div class="card">
            <div class="card-header">                
                <h5 class="card-title">
                    Reportes Personalizados
                    <button type="button" class="close" onclick="showAndHideReports(false)"><span aria-hidden="true">&times;</span></button>
                </h5>                
            </div>
            <div class="card-body">                
                <div class="form-row row">

                    <div class="col-md-6">
                        <fieldset style="margin: 8px; border: 1px solid silver; padding: 8px; border-radius: 4px">
                        <legend>Declaración Jurada por área</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" id="area_type_report" autocomplete="off" style="width: 100%">                        
                                    @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <a href="#">
                                    <button onclick="sworndeclarationpdf()"
                                        class="btn btn-success btn-block">
                                        Descargar declaración jurada
                                    </button>
                                </a>
                            </div>
                        </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset style="margin: 8px; border: 1px solid silver; padding: 8px; border-radius: 4px">
                        <legend>Listado por cargo</legend>
                        <div class="row">
                            <div class="col-md-6">
                            <select class="form-control" id="worker_type_report" autocomplete="off" style="width: 100%">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <a href="#">
                                    <button  onclick="downloadListing()"
                                        class="btn btn-success btn-block">
                                        Descargar Listado
                                    </button>
                                </a>
                            </div>
                        </div>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="display: none" id="form">
        <div class="card">
            <div class="card-header">                
                <h5 class="card-title" id="titleForm">                    
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                </h5>                
            </div>
            <div class="card-body">

                <form id="myForm" method="POST" action="#">
                    <h5>Datos Personales</h5>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="name" class="col-form-label">Nombres:</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="col-md-3">
                            <label for="lastname" class="col-form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="lastname">
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="col-form-label">Dirección:</label>
                            <textarea type="text" class="form-control" id="address"></textarea>
                        </div>
                    </div>
                                                                                    
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="document_type" class="col-form-label">Tipo de Documento:</label>
                            <select class="form-control" id="document_type" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione un tipo de documento</option>
                                @foreach($documents as $document)
                                <option value="{{ $document->id }}">{{ $document->document_type }}</option>
                                @endforeach
                            </select>                              
                        </div>
                        <div class="col-sm-3">
                            <label for="document" class="col-form-label">Documento:</label>
                            <input type="number" class="form-control" id="document"></input>
                        </div>               
                        <div class="col-sm-2">
                            <label for="birthdate" class="col-form-label">Fec. Nacimiento:</label>
                            <input type="text" id="birthdate" class="form-control"/>         
                        </div>
                        <div class="col-sm-2">
                            <label for="phone" class="col-form-label">Celular:</label>
                            <input class="form-control" id="phone"></input>
                        </div>               
                        <div class="col-sm-2">
                            <label for="email" class="col-form-label">Correo:</label>
                            <input type="email" class="form-control" id="email"></input>
                        </div>               
                    </div>                    

                    <h5>Datos de la empresa</h5>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="area_type" class="col-form-label">Seleccione un área:</label>
                            <select class="form-control" id="area_type" autocomplete="off" style="width: 100%">                        
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="worker_type" class="col-form-label">Seleccione el cargo:</label>
                            <select class="form-control" id="worker_type" autocomplete="off" style="width: 100%">                        
                                @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="col-sm-3">
                            <label for="company_id" class="col-form-label">Seleccione la empresa:</label>
                            <select class="form-control" id="company_id" autocomplete="off" style="width: 100%">                        
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="payroll" class="col-form-label">¿Está en planilla?:</label>
                            <div class="custom-control custom-switch">                                
                                <input type="checkbox" class="custom-control-input" id="payroll">
                                <label class="custom-control-label" for="payroll"></label>
                            </div>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <button id="formButton" class="btn btn-info btn-block" type="submit">Actualizar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="row">    
    <input type="hidden" class="form-control" id="cod_worker">
    <div class="col-md-12 data" id="data">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        onclick="setDataToInsert()">
                        Agregar
                    </button>

                    <button 
                        type="button" 
                        class="btn btn-primary"
                        onclick="showAndHideReports(true)">
                        Crear Reporte
                    </button>                    
                </div>                
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <label for="select_payroll" class="col-form-label">Filtrar por planilla:</label>
                        <select class="form-control" id="select_payroll" autocomplete="off" style="width: 100%">                                                            
                            <option value="">TODOS</option>                            
                            <option value="SI">SI</option>                            
                            <option value="NO">NO</option>                            
                        </select>  
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th style="width: 30%">NOMBRES</th>
                                <th style="width: 20%">EMPRESA</th>
                                <th style="width: 10%">CARGO</th>
                                <th style="width: 10%">TIP. DOC.</th>
                                <th style="width: 10%">DOCUMENTO</th>
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NOMBRES</th>
                                <th>EMPRESA</th>
                                <th>CARGO</th>                                
                                <th>TIP. DOC.</th>
                                <th>DOCUMENTO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>        
</div>
<!-- [ Main Content ] end -->

<!-- MODALS -->

<!-- MODAL TO DELETE DOCUMENT -->
<form id="formDelete" method="POST" action="trabajadores/eliminar-trabajador">
    <div class="modal fade" id="deleteWorkerModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar a esta persona?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteWorkerModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE DOCUMENT -->

<!-- MODAL TO ADD PRODUCTS TO WORKER -->
<form id="formAddProductToWorker" method="POST" action="trabajadores/agregar-producto-asignado">
    <div class="modal fade" id="AddProductWorkerModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Asignar artículos a <p id="nameToAsign"></p></h4>                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">            
                    <div class="alert alert-danger" style="display:none"></div>
                    <table class="table table-hover m-b-0 table-responsive dt-responsive" id="products_assigned">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Marca</th>
                                <th>Color</th>
                                <th>Cantidad</th>
                                <th>Eliminar?</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>                
                
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="select_category" class="col-form-label">Seleccione la categoría:</label>
                            <select class="form-control" id="select_category" autocomplete="off" style="width: 100%">                                
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>  
                        </div>
                        <div class="col-md-5">
                            <label for="product_id" class="col-form-label">Producto a agregar:</label>
                            <select class="form-control" id="product_id" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione un producto</option>
                                <option></option>                                
                            </select>  
                        </div>                        
                        <div class="col-md-2">
                            <label for="amount" class="col-form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="amount">
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeAddProductWorkerModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnAddProductToWorker" type="submit" class="btn btn-success">Agregar</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO ADD PRODUCTS TO WORKER -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/worker.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/imask.js') }}"></script>

    <script>        
    
        let worker_type_id_ToChange = 0;

        $("#select_payroll").change(function() {
            console.log(document.getElementById('select_payroll').value);
            initializeTable();
        });

        $("#area_type").change(function() {
            let area_id = document.getElementById('area_type').value;

            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url: '/areas/obtener-areas-cargo',
                data: { 'area_id': area_id },
                success:function(data) {
                    console.log(data.positions);

                    $("#worker_type").empty();

                    $.each(data.positions, function(idx, opt) {                
                        $('#worker_type').append(
                        "<option value="+opt.id+">" + opt.name + "</option>"
                        );               
                    });
                    
                },
                complete: function(data) {
                    // console.log("WTI: " + worker_type_id_ToChange);
                    if(worker_type_id_ToChange != 0){
                        $('#worker_type').val(worker_type_id_ToChange)
                        $('#worker_type').trigger('change');
                    }
                }
            });            
        })        

        var phoneMask = IMask(
            document.getElementById('phone'), {
            mask: '+{(00)} 000-000-000'
        });

        $(function() {

            $('input[id="birthdate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Até",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 0
                },
                opens: 'left'
            });
        });  

        $("#select_category").change(function() {
            
            let category_id = document.getElementById('select_category').value;

            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url: '../productos/obtener-productos-categoria',
                data: { 'category_id': category_id },
                success:function(data) {
                    console.log(data.products);

                    $("#product_id").empty();

                    $.each(data.products, function(idx, opt) {                
                        $('#product_id').append(
                        "<option value="+opt.id+">" + opt.product_name + " - " + opt.name + "</option>"
                        );               
                    });                    
                }
            });
        })

        $('#select_category').trigger('change');

        $("#document_type").select2();
        $("#worker_type").select2();
        $("#area_type").select2();
        $("#company_id").select2();
        $("#select_payroll").select2();

        $("#area_type_report").select2();
        $("#worker_type_report").select2();
    </script>
    <script>
        $("#select_category").select2({
            dropdownParent: $("#AddProductWorkerModal")
        });        

        $("#product_id").select2({
            dropdownParent: $("#AddProductWorkerModal")
        });        
    </script>

    <script>
        function downloadListing(){
            var cod_type = $('#worker_type_report').val();
            var url = '{{ route("worker.listingByPosition", ":id") }}'
            url = url.replace(':id', cod_type);
            window.open(
            url,
            "_blank"
            );   
        }

        function sworndeclarationpdf(){
            var cod_area = $('#area_type_report').val();
            var url = '{{ route("worker.sworndeclarationpdf", ":id") }}'
            url = url.replace(':id', cod_area);
            window.open(
            url,
            "_blank"
            );   
        }
    </script>
@endsection