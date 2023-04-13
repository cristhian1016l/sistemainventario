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
                "targets":[0],
                "searchable": false
            },
            {
                "targets":[3],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "', "+"'" + row.address + "',"+"'" + row.description + "'"+')"'+ 
                            'data-toggle="modal" data-target="#editStoreModal">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteStoreModal">'+
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

$("#btnInsert").click(function(e){
    e.preventDefault();    
    let address_insert = document.getElementById('address_insert').value;
    let description_insert = document.getElementById('description_insert').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formInsert').attr('action'),
        data: {'address': address_insert, 'description': description_insert },
        success:function(data) {            
            console.log(data);
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeInsertStoreModal').click();

            switch(val){
                case 500:                    
                    console.log(msg);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ha ocurrido un error, no se pudo agregar el almacén',
                        showConfirmButton: false,
                        timer: 1500
                    })                    
                    break;
                case 200:
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El almacén fue agregado exitosamente',
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

$("#btnDelete").click(function(e){
    e.preventDefault();
    let cod_store = document.getElementById('cod_store').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_store': cod_store },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeDeleteStoreModal').click();

            switch(val){
                case 500:                    
                    console.log(msg);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ha ocurrido un error, no se pudo eliminar el almacén',
                        showConfirmButton: false,
                        timer: 1500
                    })                    
                    break;
                case 200:
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El almacén fue eliminado exitosamente',
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

$("#btnEdit").click(function(e){
    e.preventDefault();
    let cod_store = document.getElementById('cod_store').value;
    let address = document.getElementById('address').value;
    let description = document.getElementById('description').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formEdit').attr('action'),
        data: {'cod_store': cod_store, 'address': address, 'description': description },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeEditStoreModal').click();

            switch(val){
                case 500:                    
                    console.log(msg);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ha ocurrido un error, no se pudo actualizar el almacén',
                        showConfirmButton: false,
                        timer: 1500
                    })                    
                    break;
                case 200:
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El almacén fue actualizado exitosamente',
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

function setDataToDelete(cod_store){    
    document.getElementById('cod_store').value = cod_store;
}

function setDataToEdit(cod_store, address, description){
    document.getElementById('cod_store').value = cod_store;
    document.getElementById("address").value = address;
    document.getElementById("description").value = description;
}

function cleanFields(){
    document.getElementById('cod_store').value = "";
    document.getElementById("address").value = "";
    document.getElementById("description").value = "";
    document.getElementById("address_insert").value = "";
    document.getElementById("description_insert").value = "";
}

// PREVENIR ENVIO CON ENTER

const $elementos = document.querySelectorAll(".form-control");

$elementos.forEach(elemento => {
	elemento.addEventListener("keydown", (evento) => {
		if (evento.key == "Enter") {
			// Prevenir
			evento.preventDefault();
			return false;
		}
	});
});

// PREVENIR ENVIO CON ENTER