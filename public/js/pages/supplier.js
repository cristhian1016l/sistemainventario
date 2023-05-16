$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/proveedores/obtener-proveedores",
            "dataSrc": function(data) {
                return data.suppliers;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[          
            {"data": "id"},
            {"data": "bussiness_name"},          
            {"data": "ruc"},
            {"data": "address"},
            {"data": "phone"},
            {"data": "landline"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[6],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "', "+"'" + row.bussiness_name + "', "+"'" + row.ruc + "', "+"'" + row.address + "', "+"'" + row.phone + "',"+"'" + row.landline + "'"+')"'+ 
                            'data-toggle="modal" data-target="#editSupplierModal">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteSupplierModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ proveedores",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
            "infoEmpty": "Mostrando 0 a 0 de 0 proveedores",
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
    let bussiness_insert = document.getElementById('bussiness_insert').value;
    let ruc_insert = document.getElementById('ruc_insert').value;
    let address_insert = document.getElementById('address_insert').value;
    let phone_insert = document.getElementById('phone_insert').value;
    let landline_insert = document.getElementById('landline_insert').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formInsert').attr('action'),
        data: {'bussiness': bussiness_insert, 'ruc': ruc_insert, 'address': address_insert, 'phone': phone_insert, 'landline': landline_insert },
        success:function(data) {                                 
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeInsertSupplierModal').click();
            console.log(msg)
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

$("#btnDelete").click(function(e){
    e.preventDefault();
    let cod_supplier = document.getElementById('cod_supplier').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_supplier': cod_supplier },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeDeleteSupplierModal').click();

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

$("#btnEdit").click(function(e){
    e.preventDefault();
    let cod_supplier = document.getElementById('cod_supplier').value;
    let bussiness = document.getElementById('bussiness').value;
    let address = document.getElementById('address').value;
    let phone = document.getElementById('phone').value;
    let landline = document.getElementById('landline').value;
    let ruc = document.getElementById('ruc').value;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formEdit').attr('action'),
        data: {'cod_supplier': cod_supplier, 'bussiness': bussiness, 'ruc': ruc, 'address': address, 'phone': phone, 'landline': landline },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeEditSupplierModal').click();

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

function setDataToDelete(cod_supplier){    
    document.getElementById('cod_supplier').value = cod_supplier;
}

function setDataToEdit(cod_supplier, bussiness, ruc, address, phone, landline){
    document.getElementById('cod_supplier').value = cod_supplier;
    document.getElementById("bussiness").value = bussiness;
    document.getElementById("ruc").value = ruc;
    document.getElementById("address").value = address;
    document.getElementById("phone").value = phone;
    document.getElementById("landline").value = landline;
}

function cleanFields(){
    document.getElementById('cod_supplier').value = "";
    document.getElementById("bussiness").value = "";
    document.getElementById("bussiness_insert").value = "";
    document.getElementById("ruc").value = "";
    document.getElementById("ruc_insert").value = "";
    document.getElementById("address").value = "";
    document.getElementById("address_insert").value = "";
    document.getElementById("phone").value = "";
    document.getElementById("phone_insert").value = "";
    document.getElementById("landline").value = "";
    document.getElementById("landline_insert").value = "";

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