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
    console.log(id_yonke);
});


table = $('#tabla_autos_cliente').DataTable({
     
    "processing": true,
    "serverSide": true,
     "ajax": './backend/autos_clientes/server_processing.php', 
     "responsive": true,
     columns: [   
       { title: "#",              data: 0    },
       { title: "Año",          data: 1       },
       { title: "Modelo",        data: 2       },
       { title: "Marca",        data: 3       },
       { title: "Stock",          data: 4       },
       { title: "Estatus",        data: 5       },
       { title: "Fecha",           data: 6       },
       ]
});
