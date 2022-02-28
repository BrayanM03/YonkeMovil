function MostrarAutos() {  
    $.fn.dataTable.ext.errMode = 'none';

    table = $('#tabla_autos_cliente').DataTable({
      
    serverSide: false,
    ajax: {
        method: "POST",
        url: "./backend/autos_clientes/traer-vehiculos.php",
        dataType: "json"
 
    },  

  columns: [   
    { title: "#",              data: null             },
    { title: "Año",            data: "Año"},
    { title: "Modelo",         data: "usuario" },
    { title: "Marca",          data: "marca"},
    { title: "Stock",          data: "stock"},
    { title: "Cantidad",       data: "cantidad"},
    { title: "Foto",
      data: null, 
      render: function (row) { 
        return '<img src="./frontend/recursos/img/pp/' +  row.usuario +'.jpg" style="width: 50px; height:50px; border-radius:45%;"></img>'
       }
    },
    { title: "Accion" ,
      data: null,
      className: "celda-acciones",
      render: function (row, data) {
        return '<a href="./editar-usuario.php?id=' +row.id+ '"><div style="display: flex"><button type="button" class="buttonPDF btn btn-success" style="margin-right: 8px"><span class="fa fa-edit"></span><span class="hidden-xs"></span></button></a><br>'+
        '<button type="button" onclick="borrarUsuario('+ row.id +');" class="buttonBorrar btn btn-warning"><span class="fa fa-trash"></span><span class="hidden-xs"></span></button></div>';
      },
    },
  ],
  paging: true,
  searching: true,
  scrollY: "30vh    ",
  info: true,
  responsive: true,
  order: [2, "desc"],
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
 
  
});

}


//MostrarAutos();

