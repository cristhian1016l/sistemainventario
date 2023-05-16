$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/equipos/obtener-equipos",
            "dataSrc": function(data) {
                return data.teams;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[          
            {"data": "id"},
            {"data": "name"},
            {"data": "names"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[0],
                "visible": false
            },
            {
                "targets":[3],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "', "+"'" + row.name + "', "+"'" + row.productor_id + "'"+')"'+ 
                            'data-toggle="modal" data-target="#editTeamModal">'+
                            '<i class="fas fa-edit"></i></button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteTeamModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ equipos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Equipos",
            "infoEmpty": "Mostrando 0 a 0 de 0 equipos",
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
    let team_insert = document.getElementById('team_insert').value;
    let productor_id_insert = document.getElementById('productor_id_insert').value;    

    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formInsert').attr('action'),
        data: {'team': team_insert, 'productor_id': productor_id_insert },
        success:function(data) { 
            console.log(data);                                
            val = data.status;
            msg = data.msg;              

            document.getElementById('closeInsertTeamModal').click();
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
                    break;
            }
            cleanFields();
            initializeTable();
        }
    });
});

// $("#btnDelete").click(function(e){
//     e.preventDefault();
//     let cod_supplier = document.getElementById('cod_supplier').value;    
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formDelete').attr('action'),
//         data: {'cod_supplier': cod_supplier },
//         success:function(data) {            
//             val = data.status;
//             msg = data.msg;              

//             document.getElementById('closeDeleteSupplierModal').click();

//             switch(val){
//                 case 500:                    
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'error',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })                    
//                     break;
//                 case 200:
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'success',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })                    
//                     break;
//             }
//             cleanFields();
//             initializeTable();
//         }
//     });
// });

// $("#btnEdit").click(function(e){
//     e.preventDefault();
//     let cod_supplier = document.getElementById('cod_supplier').value;
//     let bussiness = document.getElementById('bussiness').value;
//     let address = document.getElementById('address').value;
//     let phone = document.getElementById('phone').value;
//     let landline = document.getElementById('landline').value;
//     let ruc = document.getElementById('ruc').value;
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formEdit').attr('action'),
//         data: {'cod_supplier': cod_supplier, 'bussiness': bussiness, 'ruc': ruc, 'address': address, 'phone': phone, 'landline': landline },
//         success:function(data) {            
//             val = data.status;
//             msg = data.msg;              

//             document.getElementById('closeEditTeamModal').click();

//             switch(val){
//                 case 500:                                        
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'error',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })                    
//                     break;
//                 case 200:
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'success',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })                    
//                     break;
//             }
//             cleanFields();
//             initializeTable();
//         }
//     });
// });

function setDataToDelete(cod_team){
    document.getElementById('cod_team').value = cod_team;
}

function setDataToEdit(cod_team, team, productor_id){
    document.getElementById('cod_team').value = cod_team;
    document.getElementById("team").value = team;

    $('#productor_id').val(productor_id)            
    $('#productor_id').trigger('change');
    
}

function cleanFields(){
    document.getElementById('cod_team').value = "";
    document.getElementById("team").value = "";
    document.getElementById("team_insert").value = "";
    document.getElementById("productor_id").value = "";
    document.getElementById("productor_id_insert").value = "";
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