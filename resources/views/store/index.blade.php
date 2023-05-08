@extends('layouts.app')
@section('title', 'Almacenes')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <input type="hidden" class="form-control" id="cod_store">
    <div class="col-md-12">
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
                                <th style="width: 30%">Nombre</th>
                                <th style="width: 30%">Dirección</th>
                                <th style="width: 20%">Encargado</th>
                                <th style="width: 10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>DIRECCIÓN</th>
                                <th>ENCARGADO</th>
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
                        <label for="name_insert" class="col-form-label">Nombre del Almacén:</label>
                        <input type="text" class="form-control" id="name_insert">
                    </div>
                    <div class="form-group">
                        <label for="manager_insert" class="col-form-label">Encargado:</label>
                        <input class="form-control" id="manager_insert">
                    </div>                    
                    <div class="form-group">
                        <label for="address_insert" class="col-form-label">Dirección:</label>
                        <textarea class="form-control" id="address_insert"></textarea>
                    </div>                                        
                    <div class="form-group">
                        <label for="phone_insert" class="col-form-label">Teléfono:</label>
                        <input class="form-control" id="phone_insert">
                    </div>                    
                    <div class="form-group">
                        <label for="city_insert" class="col-form-label">Ciudad:</label>
                        <input class="form-control" id="city_insert">
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
                        <label for="name" class="col-form-label">Nombre del Almacén:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="manager" class="col-form-label">Encargado:</label>
                        <input class="form-control" id="manager">
                    </div>                    
                    <div class="form-group">
                        <label for="address" class="col-form-label">Dirección:</label>
                        <textarea class="form-control" id="address"></textarea>
                    </div>                                        
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Teléfono:</label>
                        <input class="form-control" id="phone">
                    </div>                    
                    <div class="form-group">
                        <label for="city" class="col-form-label">Ciudad:</label>
                        <input class="form-control" id="city">
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
    <script src="{{ asset('js/plugins/imask.js') }}"></script>
    <script src="{{ asset('js/pages/store.js') }}"></script>  
    <script>
        var phoneMask = IMask(
            document.getElementById('phone'), {
            mask: '+{(00)} 000-000-000'
        });

        var phoneMask = IMask(
            document.getElementById('phone_insert'), {
            mask: '+{(00)} 000-000-000'
        });
    </script>          
@endsection