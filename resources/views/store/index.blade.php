@extends('layouts.app')
@section('title', 'Almacenes')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <input type="hidden" class="form-control" id="cod_store">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">                
                <div class="button-container">                    
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#insertStoreModal">
                        Agregar
                    </button>                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th style="width: 10%">Código</th>
                                <th style="width: 40%">Dirección</th>
                                <th style="width: 40%">Descripción</th>
                                <th style="width: 10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>DIRECCIÓN</th>
                                <th>DESCRIPCIÓN</th>
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

<!-- MODAL TO INSERT STORE -->
<form id="formInsert" method="POST" action="almacenes/agregar-almacen">
    <div class="modal fade" id="insertStoreModal" tabindex="-1" role="dialog" aria-labelledby="insertStoreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertStoreModalLabel">Nuevo almacén</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">                    
                    <div class="form-group">
                        <label for="address_insert" class="col-form-label">Dirección:</label>
                        <input type="text" class="form-control" id="address_insert">
                    </div>
                    <div class="form-group">
                        <label for="description_insert" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" id="description_insert"></textarea>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button id="closeInsertStoreModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnInsert" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO INSERT STORE -->

<!-- MODAL TO EDIT STORE -->
<form id="formEdit" method="POST" action="almacenes/editar-almacen">
    <div class="modal fade" id="editStoreModal" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStoreModalLabel">Editar almacén</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">                    
                    <div class="form-group">                            
                        <label for="address" class="col-form-label">Dirección:</label>
                        <input type="text" class="form-control" id="address">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" id="description"></textarea>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button id="closeEditStoreModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnEdit" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO EDIT STORE -->

<!-- MODAL TO DELETE STORE -->
<form id="formDelete" method="POST" action="almacenes/eliminar-almacen">
    <div class="modal fade" id="deleteStoreModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este almacén?</h4>              
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>                                            
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteStoreModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE STORE -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/store.js') }}"></script>            
@endsection