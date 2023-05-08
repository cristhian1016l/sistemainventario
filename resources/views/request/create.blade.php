<?php date_default_timezone_set('America/Lima'); ?>
@extends('layouts.app')
@section('title', 'Crear Solicitud')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/plugins/daterangepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('css/plugins/toastify.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<!-- [ Main Content ] start -->

<!-- MENSAJES DE ERROR -->    
<div class="alert alert-danger" style="display:none" id="error"></div>
<!-- TERMINO DE MENSAJES DE ERROR -->

<div class="row">    
    <input type="hidden" class="form-control" id="cod_worker">
    <div class="col-sm-12 data">
        <div class="card">
            <div class="card-header">
                <h4>Crear Nueva Solicitud</h4>
            </div>
        
            <div class="card-body">
                <form method="POST" action="#">
                    @csrf
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="select-responsible" class="col-form-label">Responsable:</label>
                                <select class="form-control" id="select-responsible" autocomplete="off" style="width: 100%">
                                    <option value="">Seleccione un responsable</option>
                                    @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->lastname.' '.$worker->name }}</option>
                                    @endforeach
                                </select>  
                            </div>
                            <div class="col-md-6">

                                <label for="date" class="col-form-label">Fecha de entrega y devolución</label>
                                <input type="text" id="date" class="form-control"/>
                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-8">
                                <label for="product_id" class="col-form-label">Producto a agregar:</label>
                                <select class="form-control" id="product_id" autocomplete="off" style="width: 100%">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->description }}</option>
                                    @endforeach
                                </select>  
                            </div>
                            <div class="col-md-2">
                                <label for="amount" class="col-form-label">Cantidad:</label>
                                <input type="text" class="form-control" id="amount"/>                        
                            </div>
                            <div class="col-md-2">
                                <label for="amount" class="col-form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br>
                                <button class="btn btn-shadow btn-success" id="addProduct">
                                <i class="fas fa-plus"></i></button>                            
                            </div>
                        </div>

                    </div>       

                    <div class="form-group">
                        <button class="btn btn-info btn-block" type="submit" id="createRequest">Crear</button>
                    </div>

                </form>  
            </div>
        </div>
    </div>                 
</div>

<div class="row" id="products-row" style="display: none">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-header">
                <h5>Artículos Seleccionados</h5>
            </div>
            <div class="card-body">
                <table class="table table-responsive" id="products">
                    <thead>
                        <tr>
                            <th>ARTÍCULO</th>
                            <th>CANTIDAD</th>
                            <th>OPCIONES</th>
                        </tr>                                                
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>CPU MARCA DEEP COOL RYZEN 5 36000 6	</td>
                            <td>1</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
<!-- [ Main Content ] end -->

@endsection

@section('js')
    <!-- <script src="{{ asset('js/pages/request.js') }}"></script> -->
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/toastify-js.js') }}"></script>
    <script>

        let since_date;
        let to_date;

        $("#product_id").select2({});
        $("#select-responsible").select2({});
            
        $(function() {
            $('input[id="date"]').daterangepicker({
                "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "Até",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 0
            },
                opens: 'left'
            }, function(start, end, label) {                
                since_date = start.format('YYYY-MM-DD')
                to_date = end.format('YYYY-MM-DD')
            });
        });

        let products = new Array();

        $("#addProduct").click(function(e){            
            e.preventDefault();            

            document.getElementById("products-row").style.display = "block";

            let product_id = document.getElementById('product_id').value;            
            let amount = document.getElementById('amount').value;            

            //Get Text
            var selected = $('#product_id').select2("data");
            for (var i = 0; i <= selected.length-1; i++) {
                if(isNaN(amount) || amount == ""){
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: "Ingrese una cantidad numérica",
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else{                    
                    products.push({id: product_id, product: selected[i].text, amount: amount})                    
                    Toastify({
                        text: "Fueron añadidos "+amount + " " + selected[i].text,
                        duration: 3000
                    }).showToast();
                }
            }                        

            console.log(products);
            updateTableProduct(products)
        })

        function updateTableProduct(products){
            $("#products").slideDown("slow", function() {
                table = $("#products tbody");
                table.empty();
                let id = 0;
                $.each(products, function(idx, elem){                    
                    var options;
                    
                    options = "<td>"+
                                    elem.product+
                                "</td>"+
                                "<td>"+
                                    elem.amount+
                                "</td>"+
                                "<td>"+
                                    "<button onclick='deleteProductAssigned("+id+")' class='btn btn-sm' ><i class='feather icon-trash-2 ml-3 f-16 text-danger'></i></button>"+
                                "</td>";
                    table.append(
                        "<tr>"+
                            options+
                        "</tr>"
                    );
                    id++;
                });
            }); 
        }

        $("#createRequest").click(function(e){
            e.preventDefault();
            
            hideErrors();
            let responsible = document.getElementById('select-responsible').value;            

            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url: "agregar-solicitud",
                data: {
                        'responsible_id': responsible,
                        'since_date': since_date, 
                        'to_date': to_date, 
                        'products': products },
                success:function(data) {
                    val = data.status;
                    msg = data.msg;              
                    switch(val){
                        case 500:
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: msg,
                                showConfirmButton: false,
                                timer: 1500
                            })                                            

                            jQuery.each(data.errors, function(key, value){
                                jQuery('.alert-danger').show("slow");
                                jQuery('.alert-danger').append('<p>'+value+'</p>');
                            });
                            
                            break;
                        case 200:                            
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: msg,
                                showConfirmButton: false,
                                timer: 1500
                            })                            

                            setTimeout(() => {
                                
                                window.location.href = '{{ route("request") }}'                                

                            }, 2000);
                            
                            downloadRequestReportPDF(data.cod_request);

                            break;
                    }
                }
            });
            
        })        

        function hideErrors(){
            jQuery('.alert-danger').empty();
            const error = document.getElementById("error");
            error.style.display = "none";
        }
    
        function downloadRequestReportPDF(id){
            // let btn = document.getElementById("btnReport");
            // btn.click();

            var url = '{{ route("request.request_report", ":cod_request") }}'
            url = url.replace(':cod_request', id);
            window.open(
            url,
            "_blank"
            );   

            // $.ajax({
            //     headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     type:'POST',
            //     url: 'solicitud-pdf',
            //     data: { 'cod_request': id },
            //     success:function(data) {
            //         console.log(data);
            //     }
            // });
        }

        function deleteProductAssigned(cod_product){

            console.log(cod_product);

            products.splice(cod_product, 1);
            
            console.log(products);

            updateTableProduct(products);
            
        }
    </script>
@endsection