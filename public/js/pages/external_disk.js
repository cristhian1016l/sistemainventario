$(document).ready(function() {        
    initializeTable();
});

function initializeTable(){

    $('#dom-jqry').dataTable().fnClearTable();
    $('#dom-jqry').dataTable().fnDestroy();
    $('#dom-jqry').DataTable({        
        "ajax":{
            "type": "POST",
            "url": "/discos/obtener-discos",
            "dataSrc": function(data) {
                return data.disks;
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[                      
            {"data": "code"},
            {"data": "description"},
            {"data": "storage"},
            {"data": "name"},
            {"data": "id"},
        ],
        "columnDefs": [
            {
                "targets":[2],
                render: function(data){
                    return data+" TB";
                }
            },
            {
                "targets":[4],
                render: function(data, type, row){
                    return '<button class="btn btn-shadow btn-primary btn-sm"'+
                            'onclick="setDataToEdit('+"'" + data + "'"+')"'+ 
                            '<i class="fas fa-edit"></i>Editar</button>'+
                            '<button class="btn btn-shadow btn-danger btn-sm"'+
                            'onclick="setDataToDelete('+"'" + data + "'"+')"'+ 
                            'data-toggle="modal" data-target="#deleteDiskModal">'+
                            '<i class="fas fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Eegistros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
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

    let cod_disk = document.getElementById('cod_disk').value;
    let code = document.getElementById('code').value;
    let brand_id = document.getElementById('select-brand').value;
    let storage = document.getElementById('storage').value;    
    let in_use = document.querySelector('#in_use').checked; 
    let video_format = document.getElementById('format').value;
    let video_type = document.querySelector('input[name="radios"]:checked').value;
    let since = document.getElementById('since-date').value;
    let until = document.getElementById('until-date').value;
    let description = document.getElementById('description').value;    
    // let datesince = since.substring(0, since.length - 1);
    // console.log("FORMAROOOOOOO: "+moment(datesince, 'YYYY/MM/DD', true));
    console.log("FORMAT:" + moment(since.toString()));
    hideErrors();

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: action,
        data: {
                'id': cod_disk,
                'code': code, 
                'brand_id': brand_id,                 
                'storage': storage, 
                'in_use': in_use, 
                'video_format': video_format, 
                'video_type': video_type, 
                'since': since, 
                'until': until, 
                'description': description },
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
    let cod_disk = document.getElementById('cod_disk').value;    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: $('#formDelete').attr('action'),
        data: {'cod_disk': cod_disk },
        success:function(data) {        

            val = data.status;
            msg = data.msg;                          

            document.getElementById('closeDeleteDiskModal').click();

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

function setDataToDelete(cod_disk){    
    document.getElementById('cod_disk').value = cod_disk;
}

function setDataToInsert(){
    titleForm = document.getElementById("titleForm").innerHTML = "Agregar Disco <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);
    document.getElementById('code').disabled = false;
    cleanFields();
    document.getElementById("formButton").innerText = "Agregar";

    $('#myForm').attr('action', 'discos/agregar-disco');
}

function setDataToEdit(id){
    
    document.getElementById('cod_disk').value = id;    

    document.getElementById('code').disabled = true;

    titleForm = document.getElementById("titleForm").innerHTML = "Editar Disco <button type='button' class='close' onclick='reduceTable(false)'><span aria-hidden='true'>&times;</span></button>";
    reduceTable(true);

    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: 'discos/obtener-disco/'+id,        
        success:function(data) {                        
            const disk = data.disk                        
            console.log("FECHA: " + moment(disk['since']).format("DD/MM/YYYY"));
            document.getElementById("code").value = disk['code']
            
            $('#select-brand').val(disk['brand_id'])            
            $('#select-brand').trigger('change');            
            
            document.getElementById("storage").value = disk['storage']

            disk['in_use'] == 1 ? document.querySelector('#in_use').checked = true : document.querySelector('#in_use').checked = false;

            document.getElementById("format").value = disk['video_format'];

            $type = disk['video_type']

            switch ($type) {
                case 'en bruto':
                    let radio1 = document.getElementById("radio1");
                    radio1.checked = true;
                    break;
                case 'editado':
                    let radio2 = document.getElementById("radio2");
                    radio2.checked = true;
                    break;
                case 'ambos':
                    let radio3 = document.getElementById("radio3");
                    radio3.checked = true;
                    break;                
            }            

            document.getElementById("since-date").value = moment(disk['since']).format('DD/MM/YYYY');

            document.getElementById("until-date").value = moment(disk['until']).format('DD/MM/YYYY');

            document.getElementById("description").value = disk['description']
            
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
    $('#myForm').attr('action', 'discos/editar-disco');
}

function cleanFields(){
    document.getElementById('code').value = "";

    $('#select-brand').val("")
    $('#select-brand').trigger('change');

    document.getElementById('storage').value = "";
    
    document.querySelector('#in_use').checked = false;
    
    document.getElementById('format').value = "";
    
    let radBtnDefault = document.getElementById("radio1");
    radBtnDefault.checked = true;


    document.getElementById('since-date').value = "";    
    document.getElementById('until-date').value = "";    


    document.getElementById('description').value = "";
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