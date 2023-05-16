<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Equipos')
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
    <input type="hidden" class="form-control" id="cod_team">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="button-container">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#insertTeamModal">
                        Agregar
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width: 40%">EQUIPO</th>
                                <th style="width: 40%">PRODUCTOR</th>
                                <th style="width: 20%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>EQUIPO</th>
                                <th>PRODUCTOR</th>
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

<!-- MODAL TO INSERT TEAM -->
<form id="formInsert" method="POST" action="equipos/agregar-equipo">
    <div class="modal fade" id="insertTeamModal" tabindex="-1" role="dialog" aria-labelledby="insertTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertTeamModalLabel">Nuevo equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="team_insert" class="col-form-label">Equipo:</label>
                        <input type="text" class="form-control" id="team_insert">
                    </div>                    
                    <div class="form-group">
                        <label for="productor_id_insert" class="col-form-label">Productor:</label>
                        <select class="form-control" id="productor_id_insert" autocomplete="off" style="width: 100%">
                            <option value="">Seleccione el productor</option>
                            @foreach($productors as $productor)
                            <option value="{{ $productor->id }}">{{ $productor->names }}</option>
                            @endforeach
                        </select>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeInsertTeamModal" type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnInsert" type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO INSERT TEAM -->

<!-- MODAL TO EDIT TEAM -->
<form id="formEdit" method="POST" action="equipos/editar-equipo">
    <div class="modal fade" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="editTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeamModalLabel">Editar equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="team" class="col-form-label">Equipo:</label>
                        <input type="text" class="form-control" id="team">
                    </div>                    
                    <div class="form-group">
                        <label for="productor_id" class="col-form-label">Productor:</label>
                        <select class="form-control" id="productor_id" autocomplete="off" style="width: 100%">
                            <option value="">Seleccione el productor</option>
                            @foreach($productors as $productor)
                            <option value="{{ $productor->id }}">{{ $productor->names }}</option>
                            @endforeach
                        </select>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeEditTeamModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnEdit" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO EDIT TEAM -->

<!-- MODAL TO DELETE TEAM -->
<form id="formDelete" method="POST" action="equipos/eliminar-equipo">
    <div class="modal fade" id="deleteTeamModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este equipo?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteTeamModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE TEAM -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>    
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/team.js') }}"></script>
    <script>
        $("#productor_id_insert").select2({
            dropdownParent: $("#insertTeamModal")
        });

        $("#productor_id").select2({
            dropdownParent: $("#editTeamModal")
        });
    </script>
@endsection