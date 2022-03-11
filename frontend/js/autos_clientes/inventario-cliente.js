//Llamada que lista en el select los yonkes afiliados al usuario
$.ajax({
    type: "POST",
    url: "./backend/yonkes/traer-yonkes-cliente.php",
    data: "data",
    dataType: "JSON",
    success: function (response) {
        response.forEach(element => {
            select = $("#lista-yonke");
            select.append(`
            <option value="${element.id_yonke}">${element.nombre}</option>
            `)
           
        });
    }
}).done(function(){
    let id_yonke = $("#lista-yonke").val();
    
});


table = $('#tabla_autos_cliente').DataTable({
     
    "processing": true,
    "serverSide": true,
     "ajax": './backend/autos_clientes/server_processing.php', 
     "responsive": true,
     "order": [0, "desc"],
     "language":{
        "lengthMenu": "Se muestran _MENU_ registros por pagina.",
        "zeroRecords": "Nada encontrado - Lo siento",
        "info": "Pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No se econtraron registros.",
        "infoFiltered": "(Filtrado de _MAX_ registros totales.)",
        "processing": "Cargando, espere...",
        "search": "Buscar:",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
     },
     columns: [   
       { title: "#",              data: 0    },
       { title: "Año",            data: 1       },
       { title: "Modelo",         data: 2       },
       { title: "Marca",          data: 3       },
       { title: "Stock",          data: 4       },
       { title: "Estatus",        data: 5       },
       { title: "Fecha",          data: 6       },
       { title: "Accion:",        data: null, render: function(row, data){
         
            return `
            <div>
                <div class='btn btn-warning m-1' onclick='editarRegistro(${row[0]});'>
                    <i class='bx bx-edit'></i>
                </div>
                <div class='btn btn-danger' id="reg_${row[0]}" onclick="eliminarRegistro(${row[0]});">
                    <i class='fa fa-trash' id="icon_${row[0]}"></i>
                </div>
            </div>`;
       }},
       ]
});
