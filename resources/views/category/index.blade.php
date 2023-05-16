<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Categorias')
@section('css')
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <input type="hidden" class="form-control" id="cod_category">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#insertCategoryModal">
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
                                <th>CATEGORIA</th>
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>CATEGORIA</th>
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

<!-- MODAL TO INSERT CATEGORY -->
<form id="formInsert" method="POST" action="categorias/agregar-categoria">
    <div class="modal fade" id="insertCategoryModal" tabindex="-1" role="dialog" aria-labelledby="insertCategoryModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertCategoryModal">Nuevo categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none" id="error"></div>
                    <div class="form-group">
                        <label for="category_insert" class="col-form-label">Categoría:</label>
                        <input class="form-control" id="category_insert"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeInsertCategoryModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnInsert" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO INSERT CATEGORY -->

<!-- MODAL TO EDIT CATEGORY -->
<form id="formEdit" method="POST" action="categorias/editar-categoria">
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModal">Editar categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none" id="error"></div>
                    <div class="form-group">
                        <label for="category" class="col-form-label">Categoría:</label>
                        <input type="text" class="form-control" id="category">
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button id="closeEditCategoryModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnEdit" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO EDIT CATEGORY -->

<!-- MODAL TO DELETE CATEGORY -->
<form id="formDelete" method="POST" action="categorias/eliminar-categoria">
    <div class="modal fade" id="deleteCategoryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este categoría?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteCategoryModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE CATEGORY -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>    
    <script src="{{ asset('js/pages/category.js') }}"></script>    
@endsection