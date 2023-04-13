$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/categorias/obtener-categorias",
            "dataSrc": function(data) {
                return data.categories;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[          
            {"data": "id"},            
            {"data": "name"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[2],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "', "+"'" + row.name + "'"+')"'+ 
                            'data-toggle="modal" data-target="#editCategoryModal">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteCategoryModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ categorias",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorias",
            "infoEmpty": "Mostrando 0 a 0 de 0 categorias",
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
    let category_insert = document.getElementById('category_insert').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formInsert').attr('action'),
        data: {'category': category_insert },
        success:function(data) {                                 
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeInsertCategoryModal').click();
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
    let cod_category = document.getElementById('cod_category').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_category': cod_category },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeDeleteCategoryModal').click();

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
    let cod_category = document.getElementById('cod_category').value;
    let category = document.getElementById('category').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formEdit').attr('action'),
        data: {'cod_category': cod_category, 'category': category },
        success:function(data) {            
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeEditCategoryModal').click();

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

function setDataToDelete(cod_category){    
    document.getElementById('cod_category').value = cod_category;
}

function setDataToEdit(cod_category, category){
    document.getElementById('cod_category').value = cod_category;
    document.getElementById("category").value = category;
}

function cleanFields(){
    document.getElementById('cod_category').value = "";
    document.getElementById("category").value = "";
    document.getElementById("category_insert").value = "";
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