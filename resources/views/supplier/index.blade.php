<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Proveedores')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <input type="hidden" class="form-control" id="cod_supplier">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#insertSupplierModal">
                        Agregar
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th style="width: 10%">CÓDIGO</th>
                                <th style="width: 20%">RAZÓN SOCIAL</th>
                                <th style="width: 10%">RUC</th>
                                <th style="width: 30%">DIRECCIÓN</th>
                                <th style="width: 10%">CELULAR</th>
                                <th style="width: 10%">FIJO</th>
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>RAZÓN SOCIAL</th>
                                <th>RUC</th>
                                <th>DIRECCIÓN</th>
                                <th>CELULAR</th>
                                <th>FIJO</th>
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

<!-- MODAL TO INSERT SUPPLIER -->
<form id="formInsert" method="POST" action="proveedores/agregar-proveedor">
    <div class="modal fade" id="insertSupplierModal" tabindex="-1" role="dialog" aria-labelledby="insertSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertSupplierModalLabel">Nuevo proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bussiness_insert" class="col-form-label">Razón Social:</label>
                        <input type="text" class="form-control" id="bussiness_insert">
                    </div>
                    <div class="form-group">
                        <label for="ruc_insert" class="col-form-label">RUC:</label>
                        <input class="form-control" id="ruc_insert"></input>
                    </div>
                    <div class="form-group">
                        <label for="address_insert" class="col-form-label">Dirección:</label>
                        <textarea class="form-control" id="address_insert"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="phone_insert" class="col-form-label">Celular:</label>
                        <input class="form-control" id="phone_insert"></input>
                    </div>
                    <div class="form-group">
                        <label for="landline_insert" class="col-form-label">Teléfono Fijo:</label>
                        <input class="form-control" id="landline_insert"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeInsertSupplierModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnInsert" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO INSERT SUPPLIER -->

<!-- MODAL TO EDIT SUPPLIER -->
<form id="formEdit" method="POST" action="proveedores/editar-proveedor">
    <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Editar proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bussiness" class="col-form-label">Razón Social:</label>
                        <input type="text" class="form-control" id="bussiness">
                    </div>
                    <div class="form-group">
                        <label for="ruc" class="col-form-label">RUC:</label>
                        <input class="form-control" id="ruc"></input>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Dirección:</label>
                        <textarea class="form-control" id="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Celular:</label>
                        <input class="form-control" id="phone"></input>
                    </div>
                    <div class="form-group">
                        <label for="landline" class="col-form-label">Teléfono Fijo:</label>
                        <input class="form-control" id="landline"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeEditSupplierModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnEdit" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO EDIT SUPPLIER -->

<!-- MODAL TO DELETE SUPPLIER -->
<form id="formDelete" method="POST" action="proveedores/eliminar-proveedor">
    <div class="modal fade" id="deleteSupplierModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este proveedor?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteSupplierModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE SUPPLIER -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/imask.js') }}"></script>
    <script src="{{ asset('js/pages/supplier.js') }}"></script>

    <script>
        var phoneMask = IMask(
            document.getElementById('phone_insert'), {
            mask: '+{(00)} 000-000-000'
        });
        
        var landlineMask = IMask(
            document.getElementById('landline_insert'), {
            mask: '+{(00)} 0000000'
        });

        var phoneMask = IMask(
            document.getElementById('phone'), {
            mask: '+{(00)} 000-000-000'
        });
        
        var landlineMask = IMask(
            document.getElementById('landline'), {
            mask: '+{(00)} 0000000'
        });
    </script>
@endsection