<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Trabajadores')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<!-- [ Main Content ] start -->



<!-- MENSAJES DE ERROR -->    
<div class="alert alert-danger" style="display:none" id="error"></div>
<!-- TERMINO DE MENSAJES DE ERROR -->



<div class="row">    
    <input type="hidden" class="form-control" id="cod_worker">
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
                                <th style="width: 10%">NOMBRES</th>
                                <th style="width: 10%">APELLIDOS</th>
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
                                <th>APELLIDOS</th>
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
    <div class="col-sm-4" style="display: none" id="form">
        <div class="card">
            <div class="card-header">                
                <h5 class="card-title" id="titleForm">                    
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                </h5>                
            </div>
            <div class="card-body">

                <form id="myForm" method="POST" action="#">

                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombres:</label>
                        <input type="text" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="lastname">
                    </div>
                                                                                
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="document_type" class="col-form-label">Tipo de Documento:</label>
                            <select class="form-control" id="document_type" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione un tipo de documento</option>
                                @foreach($documents as $document)
                                <option value="{{ $document->id }}">{{ $document->document_type }}</option>
                                @endforeach
                            </select>  
                            
                        </div>
                        <div class="col-sm-6">
                            <label for="document" class="col-form-label">Documento:</label>
                            <input type="number" class="form-control" id="document"></input>
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

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/worker.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script>
        $("#document_type").select2();
    </script>
@endsection