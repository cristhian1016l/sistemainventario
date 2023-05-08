$(document).ready(function() {
    // hideOrShowTable(0);
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "solicitudes/obtener-solicitudes",
            "dataSrc": function(data) {
                console.log(data);
                return data.requests;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                                  
            {"data": "cod_request"},
            {"data": "name"},
            {"data": "date"},
            {"data": "was_entered"},
        ],
        "columnDefs": [
            {
                "targets":[0],
                "visible": false
            },
            {
                "targets":[3],
                render: function(data, type, row){

                    let was_entered = '';

                    if(row.was_entered == 0){
                        was_entered = '<button class="btn btn-shadow btn-danger btn-sm"'+                                        
                                        'onclick="wasEntered('+"'" + row.cod_request + "', "+"'" + data + "'"+')">'+ 
                                        '<i class="far fa-check-circle"></i></button>'+
                                        '<button class="btn btn-shadow btn-danger btn-sm"'+
                                        'onclick="setDataToDelete('+"'" + row.cod_request + "'"+')"'+ 
                                        'data-toggle="modal" data-target="#deleteRequestModal">'+
                                        '<i class="fas fa-trash-alt"></i></button>';
                    }

                    if(row.was_entered == 1){
                        was_entered = '<button class="btn btn-shadow btn-success btn-sm"'+                                        
                                        'onclick="wasEntered('+"'" + row.cod_request + "', "+"'" + data + "'"+')">'+ 
                                        '<i class="fas fa-minus-circle"></i></button>';
                    }

                    return was_entered+                            

                            '<a href="solicitudes/solicitud-pdf/'+row.cod_request+'" target="_blank">'+
                            '<button class="btn btn-shadow btn-primary btn-sm">'+
                            '<i class="fas fa-file-pdf"></i>'+
                            '</button>'+
                            '';
                            // '<button class="btn btn-shadow btn-info btn-sm"'+
                            // 'onclick="setDataToAsignProduct('+"'" + data + "', "+"'" + row.name + "'"+')>"'+ 
                            // '<i class="fas fa-plus"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ solicitudes",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Solicitudes",
            "infoEmpty": "Mostrando 0 a 0 de 0 solicitudes",
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

function setDataToInsert(){
    titleForm = document.getElementById("title").innerHTML = "Crear solicitud";
    cleanFields();
    document.getElementById("btnAddProductToWorker").innerText = "Crear";

    // $('#myForm').attr('action', 'trabajadores/agregar-trabajador');
}

function cleanFields(){
    // document.getElementById('cod_worker').value = "";
    // document.getElementById('name').value = "";
    // document.getElementById('lastname').value = "";
    // document.getElementById('address').value = "";
    
    // $('#select-supplier').val(1)
    // $('#select-supplier').trigger('change');
    
    // document.getElementById('document').value = "";    
}

// function hideOrShowTable(status){
//     const products_assigned = document.getElementById("products_assigned");
//     if(status === 0){
//         products_assigned.style.display = "none"
//     }

//     if(status === 1){
//         products_assigned.style.display = "block"
//     }
// }

function wasEntered(request_id, entered){

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: "solicitudes/cambiar-estado",
        data: {
                'request_id': request_id,
                'entered': entered },
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
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: msg,
                        showConfirmButton: false,
                        timer: 1500
                    })                                                
                    initializeTable();
                    break;
            }
        }
    });

}

function setDataToDelete(cod_request){
    document.getElementById('cod_request').value = cod_request;
}

$("#btnDelete").click(function(e){
    e.preventDefault();
    let cod_request = document.getElementById('cod_request').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_request': cod_request },
        success:function(data) {          
            console.log(data);  
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeDeleteRequestModal').click();

            switch(val){
                case 500:                    
                    console.log(msg);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ha ocurrido un error, no se pudo eliminar la solicitud',
                        showConfirmButton: false,
                        timer: 1500
                    })                    
                    break;
                case 200:
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'La solicitud fue eliminada correctamente',
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