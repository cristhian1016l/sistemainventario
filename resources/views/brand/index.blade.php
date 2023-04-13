@extends('layouts.app')
@section('title', 'Marcas')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <input type="hidden" class="form-control" id="cod_brand">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#insertBrandModal">
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
                                <th style="width: 60%">MARCA</th>
                                <th style="width: 15%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
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

<!-- MODAL TO INSERT BRAND -->
<form id="formInsert" method="POST" action="marcas/agregar-marca">
    <div class="modal fade" id="insertBrandModal" tabindex="-1" role="dialog" aria-labelledby="insertBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertBrandModalLabel">Nueva marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand_insert" class="col-form-label">Marca:</label>
                        <input type="text" class="form-control" id="brand_insert">
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button id="closeInsertBrandModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnInsert" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO INSERT BRAND -->

<!-- MODAL TO EDIT BRAND -->
<form id="formEdit" method="POST" action="marcas/editar-marca">
    <div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandModalLabel">Editar marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand" class="col-form-label">Marca:</label>
                        <input type="text" class="form-control" id="brand">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeEditBrandModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnEdit" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO EDIT BRAND -->

<!-- MODAL TO DELETE BRAND -->
<form id="formDelete" method="POST" action="marcas/eliminar-marca">
    <div class="modal fade" id="deleteBrandModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar esta marca?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteBrandModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE BRAND -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/brand.js') }}"></script>
@endsection