<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Gestión de memorias')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/select2.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->

<!-- MENSAJES DE ERROR -->    
<div class="alert alert-danger" style="display:none" id="error"></div>
<!-- TERMINO DE MENSAJES DE ERROR -->

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

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="name" class="col-form-label">Almacenamiento:</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="col-md-2">
                            <label for="lastname" class="col-form-label">Velocidad:</label>
                            <input type="text" class="form-control" id="lastname">
                        </div>
                        <div class="col-md-2">
                            <label for="address" class="col-form-label">Color:</label>
                            <input type="number" class="form-control" id="document"></input>
                        </div>
                        <div class="col-sm-3">
                            <label for="document" class="col-form-label">Descripción:</label>                            
                            <textarea type="text" class="form-control" id="address"></textarea>
                        </div>                                            
                        <div class="col-sm-3">                            
                            <label for="brand_id" class="col-form-label">Marca:</label>
                            <select class="form-control" id="brand_id" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione una marca</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>                              
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

                    <a href="{{ route('worker.sworndeclarationpdf') }}" target="_blank">
                        <button 
                            type="button" 
                            class="btn btn-primary">
                            Declaración Jurada PDF
                        </button>
                    </a>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>                                
                                <th style="width: 50%">ALMACENAMIENTO</th>                                
                                <th style="width: 10%">VELOCIDAD</th>
                                <th style="width: 10%">COLOR</th>
                                <th style="width: 10%">DESCRIPCIÓN</th>
                                <th style="width: 10%">MARCA</th>
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>                                
                                <th>ALMACENAMIENTO</th>                                
                                <th>VELOCIDAD</th>
                                <th>COLOR</th>
                                <th>DESCRIPCIÓN</th>
                                <th>MARCA</th>
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
<form id="formDelete" method="POST" action="memorias/eliminar-memoria">
    <div class="modal fade" id="deleteWorkerModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar esta memoria?</h4>
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

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/flashdrive.js') }}"></script>    
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script>
        $("#brand_id").select2();
    </script>
@endsection