<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Solicitudes')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
<link href="{{ asset('css/plugins/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('content')
<!-- [ Main Content ] start -->

<!-- MENSAJES DE ERROR -->    
<div class="alert alert-danger" style="display:none" id="error"></div>
<!-- TERMINO DE MENSAJES DE ERROR -->

<div class="row">    
    <input type="hidden" class="form-control" id="cod_request">
    <div class="col-sm-12 data" id="data">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <a href="{{ route('request.create') }}">
                        <button 
                            type="button" 
                            class="btn btn-primary"                        
                            data-toggle="modal"
                            data-target="#AddProductWorkerModal">
                            Crear Solicitud
                        </button>
                    </a>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>                                
                                <th style="width: 0%">ID</th>
                                <th style="width: 45%">RESPONSABLE</th>
                                <th style="width: 10%">FECHA ENTREGA</th>
                                <th style="width: 10%">FECHA DEVOL.</th>
                                <th style="width: 10%">FECHA DE ENTREGA</th>
                                <th style="width: 10%">TIEMPO</th>
                                <th style="width: 15%">ENTREGÓ?</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>RESPONSABLE</th>
                                <th>FECHA ENTREGA</th>
                                <th>FECHA DEVOL.</th>
                                <th>FECHA DE ENTREGA</th>
                                <th>TIEMPO</th>
                                <th>ENTREGÓ?</th>
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
<form id="formDelete" method="POST" action="solicitudes/eliminar-solicitud">
    <div class="modal fade" id="deleteRequestModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar esta solicitud?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteRequestModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
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
    <script src="{{ asset('js/pages/request.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker.js') }}"></script>
    <script>
        $("#document_type").select2();            
        $("#select-product").select2();            
    </script>
    <script>
        $("#product_id").select2({
            dropdownParent: $("#AddProductWorkerModal")
        });        
        $("#select-responsible").select2({
            dropdownParent: $("#AddProductWorkerModal")
        });        
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection