$(document).ready(function() {    
    initializeAreaTable();
    initializePositionTable();
});

function initializeAreaTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/areas/obtener-areas",
            "dataSrc": function(data) {                
                return data.areas;
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
                    return '<button class="btn btn-shadow btn-info btn-sm"'+
                            'onclick="filterPositions('+"'" + row.name + "', "+"'" + data + "'"+')">'+                             
                            '<i class="fas fa-eye"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ areas",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Areas",
            "infoEmpty": "Mostrando 0 a 0 de 0 areas",
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

function initializePositionTable(area_id){

    $('#position-table').dataTable().fnClearTable();
    $('#position-table').dataTable().fnDestroy();
    $('#position-table').DataTable({
        "ajax":{
            "type": "POST",
            "url": "/cargos/obtener-cargos",
            'data': {
                area_id: area_id,
             },
            "dataSrc": function(data) {                
                return data.positions;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                      
            {"data": "name"},            
        ],        
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ cargos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Cargos",
            "infoEmpty": "Mostrando 0 a 0 de 0 cargos",
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

function filterPositions(area, area_id){
    titleForm = document.getElementById("positionTitle").innerHTML = "Cargos de "+area;
    initializePositionTable(area_id)
}

// $("#btnInsert").click(function(e){
//     e.preventDefault();    
//     let brand_insert = document.getElementById('brand_insert').value;
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formInsert').attr('action'),
//         data: {'name': brand_insert},
//         success:function(data) {    
//             console.log(data);                    
//             val = data.status;
//             msg = data.msg;              

//             document.getElementById('closeInsertBrandModal').click();
//             console.log(msg)
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

// $("#btnDelete").click(function(e){
//     e.preventDefault();
//     let cod_brand = document.getElementById('cod_brand').value;    
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formDelete').attr('action'),
//         data: {'cod_brand': cod_brand },
//         success:function(data) {
//             val = data.status;
//             msg = data.msg;              

//             document.getElementById('closeDeleteBrandModal').click();

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
//     let cod_brand = document.getElementById('cod_brand').value;
//     let brand = document.getElementById('brand').value;
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formEdit').attr('action'),
//         data: {'cod_brand': cod_brand, 'brand': brand },
//         success:function(data) {            
//             val = data.status;
//             msg = data.msg;              

//             document.getElementById('closeEditBrandModal').click();

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











// function setDataToDelete(cod_brand){    
//     document.getElementById('cod_brand').value = cod_brand;
// }

// function setDataToEdit(cod_brand, brand){
//     document.getElementById('cod_brand').value = cod_brand;
//     document.getElementById("brand").value = brand;
//     console.log(cod_brand, brand)
// }

// function cleanFields(){
//     document.getElementById('cod_brand').value = "";
//     document.getElementById("brand").value = "";
//     document.getElementById("brand_insert").value = "";
// }

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