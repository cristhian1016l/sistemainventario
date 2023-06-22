<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Productos')
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
    <div class="col-md-12" id="reports">
        <div class="card">
            <div class="card-header">                
                <h5 class="card-title">
                    Reportes Personalizados
                    <button type="button" class="close" onclick="showAndHideReports(false)"><span aria-hidden="true">&times;</span></button>
                </h5>                
            </div>
            <div class="card-body">                
                <div class="form-row row">
                    <div class="col-md-6">
                        <fieldset style="margin: 8px; border: 1px solid silver; padding: 8px; border-radius: 4px">
                        <legend>Listado por categoría</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" id="select_category_report" autocomplete="off" style="width: 100%">
                                    <option value="0">TODAS LAS CATEGORÍAS</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach                                
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <a href="#">
                                    <button onclick="downloadListing()"
                                        class="btn btn-success btn-block">
                                        Descargar Reporte
                                    </button>
                                </a>                                
                            </div>

                        </div>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <input type="hidden" class="form-control" id="cod_product">
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
                                <th style="width: 40%">PRODUCTO</th>
                                <th style="width: 20%">CATEGORÍA</th>                                
                                <th style="width: 20%">MARCA</th>                                
                                <th style="width: 20%">DESCRIPCIÓN</th>
                                <th style="width: 10%">STOCK</th>
                                <th style="width: 10%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>PRODUCTO</th>
                                <th>CATEGORÍA</th>
                                <th>MARCA</th>                                
                                <th>DESCRIPCIÓN</th>
                                <th>STOCK</th>
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
                        <label for="product_name" class="col-form-label">Nombre del Producto:</label>
                        <input type="text" class="form-control" id="product_name">
                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="select-supplier" class="col-form-label">Proveedor:</label>
                            <select class="form-control" id="select-supplier" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione un proveedor</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->bussiness_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="select-brand" class="col-form-label">Marca:</label>
                            <select class="form-control" id="select-brand" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione una marca</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>  
                        </div>

                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="select-category" class="col-form-label">Categoría:</label>
                            <select class="form-control" id="select-category" autocomplete="off" style="width: 100%">
                                <option value="">Seleccione una categoría</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>  
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="col-form-label">Color:</label>
                            <input type="text" class="form-control" id="color">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="description" class="col-form-label">Descripción (opcional):</label>
                            <textarea class="form-control" id="description"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="price" class="col-form-label">Precio:</label>
                            <input class="form-control" id="price"></input>
                        </div>
                        <div class="col-sm-6">
                            <label for="stock" class="col-form-label">Stock:</label>
                            <input type="number" class="form-control" id="stock"></input>
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

<!-- MODAL TO DELETE PRODUCT -->
<form id="formDelete" method="POST" action="productos/eliminar-producto">
    <div class="modal fade" id="deleteProductModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Estás seguro que deseas eliminar este producto?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="closeDeleteProductModal" type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button id="btnDelete" type="submit" class="btn btn-success">ESTOY SEGURO</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL TO DELETE PRODUCT -->

<!-- END MODALS -->

@endsection

@section('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/product.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.priceformat.min.js') }}"></script>
    <script>

        $("#select-brand").select2();
        $("#select-category").select2();                
        $("#select-supplier").select2();                
        $("#select-store").select2();                
        $("#select_category_report").select2();                

        $('#price').priceFormat({
            limit: 7,
            centsLimit: 2,
            prefix: 'S/ ',
            centsSeparator: '.',
            thousandsSeparator: ''
        });

        function downloadListing(){
            var category_id = $('#select_category_report').val();
            var url = '{{ route("product.reports", ":id") }}'
            url = url.replace(':id', category_id);
            window.open(
            url,
            "_blank"
            );   
        }
    </script>
@endsection