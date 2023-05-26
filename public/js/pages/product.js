$(document).ready(function() {    
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({        
        "ajax":{
            "type": "POST",
            "url": "/productos/obtener-productos",
            "dataSrc": function(data) {
                return data.products;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                      
            {"data": "code"},
            {"data": "product_name"},
            {"data": "category"},
            {"data": "brand"},            
            {"data": "description"},
            {"data": "stock"},                        
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[0],
                "visible": false
            },
            {
                "targets":[6],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "'"+')"'+ 
                            '<i class="fas fa-edit"></i>Editar</button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteProductModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ productos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 productos",
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
    
    let cod_product = document.getElementById('cod_product').value;

    let product_name = document.getElementById('product_name').value;
    
    let supplier_id = document.getElementById('select-supplier').value;
    let brand_id = document.getElementById('select-brand').value;
    let category_id = document.getElementById('select-category').value;
    let color = document.getElementById('color').value;

    let description = document.getElementById('description').value;
    let price = document.getElementById('price').value;
    let stock = document.getElementById('stock').value;    

    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: action,
        data: {
                'id': cod_product,
                'product_name': product_name, 
                'supplier_id': supplier_id, 
                'brand_id': brand_id, 
                'category_id': category_id, 
                'color': color, 
                'description': description,
                'price': price,
                'stock': stock },
        success:function(data) {                                 
            

            val = data.status;
            msg = data.msg;              
            
            console.log(data.msg);            
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
                    cleanFields();
                    initializeTable();                    
                    break;
            }            
        }
    });
});

$("#btnDelete").click(function(e){
    e.preventDefault();
    let cod_product = document.getElementById('cod_product').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_product': cod_product },
        success:function(data) {        

            val = data.status;
            msg = data.msg;                          

            document.getElementById('closeDeleteProductModal').click();

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

function setDataToDelete(cod_product){    
    document.getElementById('cod_product').value = cod_product;
}

function setDataToInsert(){
    titleForm = document.getElementById("titleForm").innerHTML = "Agregar Producto <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);
    cleanFields();
    document.getElementById("formButton").innerText = "Agregar";

    $('#myForm').attr('action', 'productos/agregar-producto');
}

function setDataToEdit(id){
    document.getElementById('cod_product').value = id;

    titleForm = document.getElementById("titleForm").innerHTML = "Editar Producto <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: 'productos/obtener-producto/'+id,        
        success:function(data) {                        
            const product = data.product            
            console.log(product);
            document.getElementById("product_name").value = product['product_name']
            document.getElementById("description").value = product['description']
                        
            $('#select-brand').val(product['brand_id'])            
            $('#select-brand').trigger('change');

            $('#select-supplier').val(product['supplier_id'])            
            $('#select-supplier').trigger('change');

            $('#select-category').val(product['category_id'])            
            $('#select-category').trigger('change');            

            document.getElementById("color").value = product['color']
            document.getElementById("price").value = product['price']
            document.getElementById("stock").value = product['stock']
            
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
    $('#myForm').attr('action', 'productos/editar-producto');
}

function cleanFields(){
    document.getElementById('cod_product').value = "";
    document.getElementById('product_name').value = "";

    $('#select-supplier').val("")
    $('#select-supplier').trigger('change');

    $('#select-brand').val("")
    $('#select-brand').trigger('change');
        
    $('#select-category').val("")
    $('#select-category').trigger('change');

    $('#select-store').val("")
    $('#select-store').trigger('change');

    document.getElementById('color').value = "";
    document.getElementById('description').value = "";
    document.getElementById('price').value = "";
    document.getElementById('stock').value = "";
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

function hideErrors(){
    jQuery('.alert-danger').empty();
    const error = document.getElementById("error");
    error.style.display = "none";
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