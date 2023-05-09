$(document).ready(function() {
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "trabajadores/obtener-trabajadores",
            "dataSrc": function(data) {
                return data.workers;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                                  
            {"data": "names"},
            {"data": "type"},
            {"data": "area"},
            {"data": "document_type"},
            {"data": "document"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[5],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "'"+')"'+                             
                            '<i class="fas fa-edit"></i>Editar</button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteWorkerModal">'+
                            '<i class="fas fa-trash-alt"></i></button>'+
                            '<button class="btn btn-shadow btn-info btn-sm"'+
                            'onclick="setDataToAsignProduct('+"'" + data + "', "+"'" + row.names + "'"+')"'+ 
                            'data-toggle="modal" data-target="#AddProductWorkerModal">'+
                            '<i class="fas fa-plus"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ trabajadores",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Trabajadores",
            "infoEmpty": "Mostrando 0 a 0 de 0 trabajadores",
            "infoFiltered": "(Filtrado de _MAX_ registros)",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "paginate": {
                "first": "primero",
                "last": "último",
                "next": "siguiente",
                "previous": "anterior"
            },
        },
    });
}

$("#formButton").click(function(e){
    e.preventDefault();    
    const action = $('#myForm').attr('action');
    
    let cod_worker = document.getElementById('cod_worker').value;
    let name = document.getElementById('name').value;
    let lastname = document.getElementById('lastname').value;    
    let address = document.getElementById('address').value;    

    let document_type_id = document.getElementById('document_type').value;
    
    let document_number = document.getElementById('document').value;    

    let worker_type_id = document.getElementById('worker_type').value;

    let area_type = document.getElementById('area_type').value;

    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: action,
        data: {
                'id': cod_worker,
                'name': name, 
                'lastname': lastname, 
                'address': address, 
                'document_type_id': document_type_id,                 
                'worker_type_id': worker_type_id,
                'area_type': area_type,
                'document': document_number },
        success:function(data) {

            console.log(data);

            val = data.status;
            msg = data.msg;              
            
            console.log(data.msg);            
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
                    reduceTable(false);
                    cleanFields();
                    initializeTable();
                    break;
            }            
        }
    });
});

$("#btnAddProductToWorker").click(function(e){
    e.preventDefault();
    let cod_worker = document.getElementById('cod_worker').value;    
    let product_id = document.getElementById('product_id').value;
    let amount = document.getElementById('amount').value;

    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formAddProductToWorker').attr('action'),
        data: {'cod_worker': cod_worker, "product_id": product_id, "amount": amount },
        success:function(data) {
            val = data.status;
            msg = data.msg;                                      

            switch(val){
                case 500:                    
                    jQuery.each(data.errors, function(key, value){
                        jQuery('.alert-danger').show("slow");
                        jQuery('.alert-danger').append('<p>'+value+'</p>');
                    });                    
                    break;
                case 200:
                    // document.getElementById('closeAddProductWorkerModal').click();
                    // Swal.fire({
                    //     position: 'center',
                    //     icon: 'success',
                    //     title: msg,
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // })
                    getProductsAssigned(cod_worker);
                    cleanProducts();
                    break;
            }
        }
    });
});

$("#btnDelete").click(function(e){
    e.preventDefault();
    let cod_worker = document.getElementById('cod_worker').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_worker': cod_worker },
        success:function(data) {
            val = data.status;
            msg = data.msg;

            document.getElementById('closeDeleteWorkerModal').click();

            switch(val){
                case 500:                    
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    break;
                case 200:
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: msg,
                        showConfirmButton: false,
                        timer: 1500
                    })                    
                    break;
            }
            cleanFields();
            initializeTable();
        }
    });
});

function setDataToDelete(cod_worker){
    document.getElementById('cod_worker').value = cod_worker;
}

function deleteProductAssigned(cod_worker, product_worker_id){
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: 'trabajadores/eliminar-producto-asignado',
        data: {'product_worker_id': product_worker_id },
        success:function(data) {
            console.log(data);
            val = data.status;
            msg = data.msg;

            // document.getElementById('closeDeleteWorkerModal').click();

            switch(val){
                case 500:                    
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    break;
                case 200:                    
                    getProductsAssigned(cod_worker);
                    cleanProducts();
                    break;
            }
        }
    });    
}

function setDataToAsignProduct(cod_worker, name){
    document.getElementById('cod_worker').value = cod_worker;
    document.getElementById('nameToAsign').innerHTML = name;
    console.log(cod_worker+ ' '+name);
      
    getProductsAssigned(cod_worker);

}

function getProductsAssigned(cod_worker){
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: "trabajadores/obtener-productos-asignados",
        data: {'cod_worker': cod_worker },
        success:function(data) {
            console.log(data);
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
                    break;
                case 200:                                
                    $("#products_assigned").slideDown("slow", function() {
                        table = $("#products_assigned tbody");
                        table.empty();
                        $.each(data.products, function(idx, elem){
                            var options;
                            
                            options = "<td>"+
                                            elem.description+
                                        "</td>"+
                                        "<td>"+
                                            elem.name+
                                        "</td>"+
                                        "<td>"+
                                            elem.amount+
                                        "</td>"+
                                        "<td>"+
                                            "</a><a onclick='deleteProductAssigned("+cod_worker+', '+ elem.id +")'><i class='feather icon-trash-2 ml-3 f-16 text-danger'></i></a>"+
                                        "</td>";
                            table.append(
                                "<tr>"+
                                    options+
                                "</tr>"
                            );
                        });
                    });                
                    break;
            }
        }
    });
}

function setDataToInsert(){
    titleForm = document.getElementById("titleForm").innerHTML = "Agregar Trabajador <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);
    cleanFields();
    document.getElementById("formButton").innerText = "Agregar";

    $('#myForm').attr('action', 'trabajadores/agregar-trabajador');
}

function setDataToEdit(id){
    document.getElementById('cod_worker').value = id;

    titleForm = document.getElementById("titleForm").innerHTML = "Editar Trabajador <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: 'trabajadores/obtener-trabajador/'+id,        
        success:function(data) {
            const worker = data.worker            
            console.log(worker);
            document.getElementById("name").value = worker['name']
            document.getElementById("lastname").value = worker['lastname']
            document.getElementById("address").value = worker['address']
                        
            $('#document_type').val(worker['document_type_id'])
            $('#document_type').trigger('change');
                        
            $('#worker_type').val(worker['worker_type_id'])
            $('#worker_type').trigger('change');

            $('#area_type').val(worker['area_type_id'])
            $('#area_type').trigger('change');
            
            document.getElementById("document").value = worker['document']
            
            switch(data.status){
                case 500:
                    msg = data.msg;
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: false,
                        timer: 1500
                    })       
                    break;
            }
        }
    });
    document.getElementById("formButton").innerText = "Actualizar"
    $('#myForm').attr('action', 'trabajadores/editar-trabajador');
}

function cleanFields(){
    document.getElementById('cod_worker').value = "";
    document.getElementById('name').value = "";
    document.getElementById('lastname').value = "";
    document.getElementById('address').value = "";
    
    $('#document_type').val("")
    $('#document_type').trigger('change');

    $('#worker_type').val(1)
    $('#worker_type').trigger('change');

    $('#area_type').val(1)
    $('#area_type').trigger('change');
    
    document.getElementById('document').value = "";    
}

function cleanProducts(){
    
    $('#product_id').val("")
    $('#product_id').trigger('change');
    
    document.getElementById('amount').value = "";
}

function reduceTable(state){
    const table = document.getElementsByClassName("data");
    const form = document.getElementById("form")
    if(state == false){
        table[0].classList.add("col-sm-12");
        table[0].classList.remove("col-sm-8");
        form.style.display = "none"
    }
    if(state == true){
        table[0].classList.add("col-sm-8");
        table[0].classList.remove("col-sm-12");
        form.style.display = "block"
    }
}

function hideErrors(){
    jQuery('.alert-danger').empty();
    const error = document.getElementById("error");
    error.style.display = "none";
}

// // PREVENIR ENVIO CON ENTER

// const $elementos = document.querySelectorAll(".form-control");

// $elementos.forEach(elemento => {
// 	elemento.addEventListener("keydown", (evento) => {
// 		if (evento.key == "Enter") {
// 			// Prevenir
// 			evento.preventDefault();
// 			return false;
// 		}
// 	});
// });

// // PREVENIR ENVIO CON ENTER