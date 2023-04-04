$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/almacenes/obtener-almacenes",
            "dataSrc": function(data) {
                return data.stores;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[          
            {"data": "id"},
            {"data": "address"},          
            {"data": "description"},            
            {"data": "id"},            
        ],
        "columnDefs": [
            {
                "targets":[3],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setData('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#modal-default">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setData('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#modal-default">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ almacenes",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Almacenes",
            "infoEmpty": "Mostrando 0 a 0 de 0 almacenes",
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

$("#btnDelete").click(function(e){
    e.preventDefault();
    var form = $('#formDelete').attr('action');
    let cod_store = document.getElementById('cod_store').value;    
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
        "ajax":{
        "type": "POST",
        "url": form,
        "data": {'cod_store': cod_store },
        "dataSrc": function(data){

            val = data.error; 

            if(val === "500"){                              
                toastr.error("Ha ocurrido un error, no se pudo dar de baja al miembro")
            }else{                
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success('El miembro ha sido dado de baja exitosamente');
                document.getElementById('cod_store').value = '';                
                document.getElementById('close').click();
                return data.stores;
            }

        },
        "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        },                
        "columns":[          
            {"data": "id"},
            {"data": "address"},          
            {"data": "description"},            
            {"data": "id"},            
        ],
        "columnDefs": [
            {
                "targets":[3],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setData('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#modal-default">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setData('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#modal-default">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ almacenes",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Almacenes",
            "infoEmpty": "Mostrando 0 a 0 de 0 almacenes",
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
    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();    
})

function setData(cod_store){    
    document.getElementById('cod_store').value = cod_store;      
}