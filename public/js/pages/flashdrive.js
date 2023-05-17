$(document).ready(function() {
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({
        "ajax":{
            "type": "POST",
            "url": "memorias/obtener-memorias",
            "dataSrc": function(data) {
                return data.flashdrives;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                                  
            {"data": "storage"},
            {"data": "speed"},
            {"data": "color"},
            {"data": "description"},
            {"data": "brand_id"},
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
    
    let cod_flashdrive = document.getElementById('cod_flashdrive').value;
    let storage = document.getElementById('storage').value;
    let speed = document.getElementById('speed').value;
    let color = document.getElementById('color').value;    
    let description = document.getElementById('description').value;    
    let brand_id = document.getElementById('brand_id').value;
    let stock = document.getElementById('stock').value;

    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: action,
        data: {
                'id': cod_flashdrive,
                'storage': storage,
                'speed': speed,
                'color': color,
                'description': description,
                'brand_id': brand_id,
                'stock': stock },
        success:function(data) {

            console.log(data);

            // val = data.status;
            // msg = data.msg;              
            
            // console.log(data.msg);            
            // switch(val){
            //     case 500:                                        
            //         Swal.fire({
            //             position: 'center',
            //             icon: 'error',
            //             title: msg,
            //             showConfirmButton: false,
            //             timer: 1500
            //         })                                            

            //         jQuery.each(data.errors, function(key, value){
            //             jQuery('.alert-danger').show("slow");
            //             jQuery('.alert-danger').append('<p>'+value+'</p>');
            //         });
                    
            //         break;
            //     case 200:                    
            //         Swal.fire({
            //             position: 'center',
            //             icon: 'success',
            //             title: msg,
            //             showConfirmButton: false,
            //             timer: 1500
            //         })
            //         reduceTable(false);
            //         cleanFields();
            //         initializeTable();
            //         break;
            // }            
        }
    });
});

// $("#btnDelete").click(function(e){
//     e.preventDefault();
//     let cod_worker = document.getElementById('cod_worker').value;    
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: $('#formDelete').attr('action'),
//         data: {'cod_worker': cod_worker },
//         success:function(data) {
//             val = data.status;
//             msg = data.msg;

//             document.getElementById('closeDeleteWorkerModal').click();

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

// function setDataToDelete(cod_worker){
//     document.getElementById('cod_worker').value = cod_worker;
// }

// function deleteProductAssigned(cod_worker, product_worker_id){
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: 'trabajadores/eliminar-producto-asignado',
//         data: {'product_worker_id': product_worker_id },
//         success:function(data) {
//             console.log(data);
//             val = data.status;
//             msg = data.msg;

//             // document.getElementById('closeDeleteWorkerModal').click();

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
//                     getProductsAssigned(cod_worker);
//                     cleanProducts();
//                     break;
//             }
//         }
//     });    
// }

// function setDataToAsignProduct(cod_worker, name){
//     document.getElementById('cod_worker').value = cod_worker;
//     document.getElementById('nameToAsign').innerHTML = name;
//     console.log(cod_worker+ ' '+name);
      
//     getProductsAssigned(cod_worker);

// }

// function getProductsAssigned(cod_worker){
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: "trabajadores/obtener-productos-asignados",
//         data: {'cod_worker': cod_worker },
//         success:function(data) {
//             console.log(data);
//             val = data.status;
//             msg = data.msg;                          

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
//                     $("#products_assigned").slideDown("slow", function() {
//                         table = $("#products_assigned tbody");
//                         table.empty();
//                         $.each(data.products, function(idx, elem){
//                             var options;
                            
//                             options = "<td>"+
//                                             elem.product_name+
//                                         "</td>"+
//                                         "<td>"+
//                                             elem.name+
//                                         "</td>"+
//                                         "<td>"+
//                                             elem.amount+
//                                         "</td>"+
//                                         "<td>"+
//                                             "</a><a onclick='deleteProductAssigned("+cod_worker+', '+ elem.id +")'><i class='feather icon-trash-2 ml-3 f-16 text-danger'></i></a>"+
//                                         "</td>";
//                             table.append(
//                                 "<tr>"+
//                                     options+
//                                 "</tr>"
//                             );
//                         });
//                     });                
//                     break;
//             }
//         }
//     });
// }

function setDataToInsert(){
    titleForm = document.getElementById("titleForm").innerHTML = "Agregar Memoria <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);
    cleanFields();
    document.getElementById("formButton").innerText = "Agregar";

    $('#myForm').attr('action', 'memorias/agregar-memoria');
}

// function setDataToEdit(id){
//     document.getElementById('cod_worker').value = id;

//     titleForm = document.getElementById("titleForm").innerHTML = "Editar Trabajador <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
//     reduceTable(true);

//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: 'trabajadores/obtener-trabajador/'+id,        
//         success:function(data) {
//             const worker = data.worker            
//             console.log(worker);
//             document.getElementById("name").value = worker['name']
//             document.getElementById("lastname").value = worker['lastname']
//             document.getElementById("address").value = worker['address']
                        
//             $('#document_type').val(worker['document_type_id'])
//             $('#document_type').trigger('change');
                        
//             $('#worker_type').val(worker['worker_type_id'])
//             $('#worker_type').trigger('change');

//             $('#area_type').val(worker['area_type_id'])
//             $('#area_type').trigger('change');
            
//             document.getElementById("document").value = worker['document']
            
//             switch(data.status){
//                 case 500:
//                     msg = data.msg;
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'error',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })       
//                     break;
//             }
//         }
//     });
//     document.getElementById("formButton").innerText = "Actualizar"
//     $('#myForm').attr('action', 'trabajadores/editar-trabajador');
// }

function cleanFields(){
    document.getElementById('storage').value = "";
    document.getElementById('speed').value = "";
    document.getElementById('color').value = "";
    document.getElementById('description').value = "";
    
    $('#brand_id').val(1)
    $('#brand_id').trigger('change');    
}

// function cleanProducts(){
    
//     $('#product_id').val("")
//     $('#product_id').trigger('change');
    
//     document.getElementById('amount').value = "";
// }

function reduceTable(state){    
    const form = document.getElementById("form")
    if(state == false){        
        form.style.display = "none"
    }
    if(state == true){
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