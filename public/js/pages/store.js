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
            {"data": "name"},
            {"data": "address"},
            {"data": "manager"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[0],
                "searchable": false,
                "visible": false
            },
            {
                "targets":[4],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            // 'onclick="setDataToEdit('+"'" + data + "', "+"'" + row.name + "',"+"'" + row.address + "'"+')"'+ 
                            'onclick="setDataToEdit('+"'" + data + "'"+')"'+ 
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
    let name_insert = document.getElementById('name_insert').value;
    let manager_insert = document.getElementById('manager_insert').value;
    let address_insert = document.getElementById('address_insert').value;
    let phone_insert = document.getElementById('phone_insert').value;
    let city_insert = document.getElementById('city_insert').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formInsert').attr('action'),
        data: {'name': name_insert, 'manager': manager_insert, 'address': address_insert, 'phone': phone_insert, 'city': city_insert },
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
    let name = document.getElementById('name').value;
    let address = document.getElementById('address').value;
    let manager = document.getElementById('manager').value;
    let phone = document.getElementById('phone').value;
    let city = document.getElementById('city').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formEdit').attr('action'),
        data: {'cod_store': cod_store, 'name': name, 'address': address, 'manager': manager, 'phone': phone, 'city': city },
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

function setDataToEdit(cod_store){
    document.getElementById('cod_store').value = cod_store;

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: 'almacenes/obtener-almacen/'+cod_store,
        success:function(data) {               

            const store = data.store            
            console.log(store);

            document.getElementById("name").value = store['name'];
            document.getElementById("manager").value = store['manager'];                    
            document.getElementById("address").value = store['address'];                    
            document.getElementById("phone").value = store['phone'];                    
            document.getElementById("city").value = store['city'];                    
            
            // $('#select-supplier').val(store['supplier_id'])            
            // $('#select-supplier').trigger('change');

            // $('#select-category').val(store['category_id'])            
            // $('#select-category').trigger('change');

            // $('#select-store').val(store['store_id'])            
            // $('#select-store').trigger('change');

            // document.getElementById("price").value = store['price']
            // document.getElementById("stock").value = store['stock']
            
            // switch(data.status){
            //     case 500:                    
            //         msg = data.msg;                          
            //         Swal.fire({
            //             position: 'center',
            //             icon: 'error',
            //             title: msg,
            //             showConfirmButton: false,
            //             timer: 1500
            //         })                    
            //         break;                
            // }
        }
    });

    
}

function cleanFields(){
    document.getElementById('cod_store').value = "";
    document.getElementById("name_insert").value = "";
    document.getElementById("manager_insert").value = "";
    document.getElementById("address_insert").value = "";
    document.getElementById("phone_insert").value = "";
    document.getElementById("city_insert").value = "";
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