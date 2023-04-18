$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({        
        // "sScrollX": "100%",
		// "sScrollXInner": "100%",
		// "bScrollCollapse": true,
        "ajax":{
            "type": "POST",
            "url": "/trabajadores/obtener-trabajadores",
            "dataSrc": function(data) {
                return data.workers;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                                  
            {"data": "name"},
            {"data": "lastname"},
            {"data": "document_type_id"},
            {"data": "document"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[4],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "'"+')"'+                             
                            '<i class="fas fa-edit"></i>Editar</button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteWorkerModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
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

// $("#formButton").click(function(e){
//     e.preventDefault();    
//     const action = $('#myForm').attr('action');
    
//     let cod_worker = document.getElementById('cod_worker').value;

//     let product_name = document.getElementById('product_name').value;
    
//     let supplier_id = document.getElementById('select-supplier').value;
//     let brand_id = document.getElementById('select-brand').value;
//     let category_id = document.getElementById('select-category').value;
//     let store_id = document.getElementById('select-store').value;

//     let description = document.getElementById('description').value;
//     let price = document.getElementById('price').value;
//     let stock = document.getElementById('stock').value;    

//     hideErrors();

//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:'POST',
//         url: action,
//         data: {
//                 'id': cod_worker,
//                 'product_name': product_name, 
//                 'supplier_id': supplier_id, 
//                 'brand_id': brand_id, 
//                 'category_id': category_id, 
//                 'store_id': store_id,
//                 'description': description,
//                 'price': price,
//                 'stock': stock },
//         success:function(data) {                                 
            

//             val = data.status;
//             msg = data.msg;              
            
//             console.log(data.msg);            
//             switch(val){                
//                 case 500:                                        
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'error',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })                                            

//                     jQuery.each(data.errors, function(key, value){
//                         jQuery('.alert-danger').show("slow");
//                         jQuery('.alert-danger').append('<p>'+value+'</p>');
//                     });
                    
//                     break;
//                 case 200:                    
//                     Swal.fire({
//                         position: 'center',
//                         icon: 'success',
//                         title: msg,
//                         showConfirmButton: false,
//                         timer: 1500
//                     })
//                     cleanFields();
//                     initializeTable();                    
//                     break;
//             }            
//         }
//     });
// });

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
                        
            $('#document_type').val(worker['document_type'])
            $('#document_type').trigger('change');
                        
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
    
    $('#select-supplier').val(1)
    $('#select-supplier').trigger('change');
    
    document.getElementById('document').value = "";    
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

// function hideErrors(){
//     jQuery('.alert-danger').empty();
//     const error = document.getElementById("error");
//     error.style.display = "none";
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