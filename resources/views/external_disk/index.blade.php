<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Gestión de Discos Duros Externos')
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
    <input type="hidden" class="form-control" id="cod_disk">
    <div class="col-sm-12 data" id="data">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        onclick="setDataToInsert()">
                        Agregar
                    </button>                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th style="width: 50%">DESCRIPCIÓN</th>
                                <th style="width: 20%">CAPACIDAD</th>
                                <th style="width: 20%">MARCA</th>                                
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>CAPACIDAD</th>
                                <th>MARCA</th>                                
                                <th>ACCIONES</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4" style="display: none" id="form">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="titleForm">
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                </h5>
            </div>
            <div class="card-body">

                <form id="myForm" method="POST" action="#">

                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="code" class="col-form-label">Código:</label>
                            <input type="text" class="form-control" id="code" maxlength="10">
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="col-form-label">Generar:</label>
                            <button class="btn btn-success" type="button" onclick="generateCode()">Gen</button>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label for="select-brand" class="col-form-label">Marca:</label>
                        <select class="form-control" id="select-brand" autocomplete="off" style="width: 100%">
                            <option value="">Seleccione una marca</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="storage" class="col-form-label">Capacidad:</label>
                            <div class="input-group">                        
                                <input type="number" class="form-control" id="storage">
                                <div class="input-group-append">
                                    <span class="input-group-text">TB</span>
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="in_use" class="col-form-label" id="in_use_label"></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="in_use">
                                <label class="custom-control-label" for="in_use"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="format" class="col-form-label">Formato de vídeos guardados:</label>
                            <input type="text" class="form-control" id="format">
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Vídeos</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio1" value="en bruto" checked="">
                                    <label class="form-check-label" for="radio1">En Bruto</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio2" value="editado">
                                    <label class="form-check-label" for="radio2">Editados</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio3" value="ambos">
                                    <label class="form-check-label" for="radio3">Ambos</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="description" class="col-form-label">Vídeos Desde:</label>                                                        
                            <input type="text" id="since-date" class="form-control"/>         
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="col-form-label">Vídeos Hasta:</label>                            
                            <input type="text" id="until-date" class="form-control"/>         
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="description" class="col-form-label">Descripción (opcional):</label>
                            <textarea class="form-control" id="description"></textarea>
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
<!-- [ Main Content ] end -->

<!-- MODALS -->

<!-- MODAL TO DELETE DISK -->
<form id="formDelete" method="POST" action="discos/eliminar-disco">
    <div class="modal fade" id="deleteDiskModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este disco?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteDiskModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE DISK -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/external_disk.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>   
    <script src="{{ asset('js/plugins/moment.min.js') }}"></script> 
    <script src="{{ asset('js/plugins/daterangepicker.js') }}"></script>
    <script>

        let option = 
        {
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
        }
        
        $('input[id="since-date"]').daterangepicker(option);
        $('input[id="until-date"]').daterangepicker(option);

        $("#select-brand").select2();
        
        function generateCode(){
            let code = Math.floor(Math.random() * (999999 - 100000 + 1) ) + 100000;
            document.getElementById('code').value = "DIEX"+ code;
        }
        
        $('#in_use').change(function() { 
            let payroll = document.querySelector('#in_use').checked;    

            if(payroll == false){
                document.getElementById('in_use_label').innerHTML = "Estado: En uso";
            }else{
                document.getElementById('in_use_label').innerHTML = "Estado: Almacenado";
            }
        });
        $('#in_use').trigger('change');        

    </script>
@endsection