@extends('layouts.app')
@section('title', 'Panel de Control')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card flat-card">
            <div class="row-table">
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="icon feather icon-users text-primary mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-8 text-md-center">
                            <h5>{{ $workers[0]->total }}</h5>
                            <span>Trabajadores</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body br">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="icon feather icon-rotate-ccw text-primary mb-1 d-block"></i>
                        </div>
                        <div class="col-sm-8 text-md-center">
                            <h5>{{ $products[0]->total }}</h5>
                            <span>Productos</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="icon feather icon-shopping-cart text-primary mb-1 d-blockz"></i>
                        </div>
                        <div class="col-sm-8 text-md-center">
                            <h5>{{ $suppliers[0]->total }}</h5>
                            <span>Proveedores</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="icon feather icon-shopping-cart text-primary mb-1 d-blockz"></i>
                        </div>
                        <div class="col-sm-8 text-md-center">
                            <h5>{{ $requests[0]->total }}</h5>
                            <span>Solicitudes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-info" role="alert">
        Pronto estaremos agregando <a class="alert-link">reportes al sistema</a>. Siga brindándonos datos.
    </div>
@endsection
@section('js')
@endsection