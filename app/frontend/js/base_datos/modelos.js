function MostrarModelos() {  
    $.fn.dataTable.ext.errMode = 'none';

    table = $('#tabla-modelos').DataTable({
      
    serverSide: false,
    ajax: {
        method: "POST",
        url: "./app/backend/base_datos/traer-modelos.php",
        dataType: "json"
 
    },  

  columns: [   
    { title: "#",              data: null             },
    { title: "Codigo",         data: "id", render: function(data,type,row) {
        return '<span>MOD'+ data +'</span>';
        }},
   // { title: "Imagen",         data: "codigo"         },
    { title: "Marca",          data: "marca"       },
    { title: "Modelo",         data: "modelo" , width: "20%"  },
    { title: "Año",            data: "año"         },
    { title: "Accion",
      data: null,
      className: "celda-acciones",
      render: function (row, data) {
        return '<div style="display: flex"><button onclick="editarModelo(' +row.id+ ');" type="button" class="buttonPDF btn btn-success" style="margin-right: 8px"><span class="fa fa-edit"></span><span class="hidden-xs"></span></button><br>'+
        '<button type="button" onclick="borrarModelo('+ row.id +');" class="buttonBorrar btn btn-warning"><span class="fa fa-trash"></span><span class="hidden-xs"></span></button></div>';
      },
    },
  ],
  paging: true,
  searching: true,
  scrollY: "30vh    ",
  info: true,
  responsive: true,
  order: [2, "desc"],
 
  
});

$("table.dataTable thead").addClass("table-info")

 //Enumerar las filas "index column"
 table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
       
    } );
} ).draw();

}

MostrarModelos();


function agregarModelo() {

    Swal.fire({
      title: "Agregar proveedor nuevo",
      html: '<form class="mt-4" id="agregar-proveedor">'+
  
  
          '<div class="col-12">'+
          '<div class="form-group">'+
          '<label><b>Marca</b></label>'+
          '<select id="marca" name="marca" class="form-control"></select>'+
          '</div>'+
          '</div>'+
  
  
      '</div>'+
  
      '<div class="row">'+
  
          '<div class="col-6">'+
          '<div class="form-group">'+
          '<label><b>Telefono</b></label>'+
          '<input type="number" class="form-control" name="telefono" id="telefono" placeholder="+52 ...">'+
      '</div>'+
    '</div>'+
    '<div class="col-6">'+
          '<div class="form-group">'+
          '<label><b>RFC</b></label>'+
            '<input type="text" class="form-control" name="rfc" id="rfc" placeholder="RFC">'+
      '</div>'+
    '</div>'+
    '<div class="col-12">'+
          '<div class="form-group">'+
          '<label><b>Correo</b></label>'+
          '<input type="text" class="form-control m-auto" name="correo" id="correo" placeholder="Correo">'+
      '</div>'+
    '</div>'+
  
          '</div>'+
      '</div>'+
  
      '<div class="row  mt-1">'+
      '<div class="col-12">'+
      '<div class="form-group" id="area-solucion">'+
      '<label><b>Dirección</b></label>'+
      '<textarea class="form-control" style="height:100px" name="direccion" id="direccion" form="formulario-editar-registro" placeholder="Escriba la dirección del producto"></textarea>'+
      '</div>'+
      '</div>'+
      '</div>'+
              '</div>'+
  '</form>',
      showCancelButton: true,
      cancelButtonText: 'Cerrar',
      cancelButtonColor: '#00e059',
      showConfirmButton: true,
      confirmButtonText: 'Agregar',
      cancelButtonColor:'#ff764d',
      focusConfirm: false,
      iconColor : "#36b9cc",
      showLoaderOnConfirm: true,
      didOpen: function (param) { 

        //Buscar marcas

        $("#marca").select2({
            placeholder: "Busca una marca...",
            theme: "bootstrap",
            minimumInputLength: 1,
            ajax: {
                url: "./app/backend/base_datos/traer-marca.php",
                type: "post",
                dataType: 'json',
                delay: 250,

                data: function (params) {
                 return {
                   searchTerm: params.term // search term

                 };
                },
                processResults: function (data) {
                    return {
                       results: data
                    };
                  },

                cache: true

            },
            language:  {

                inputTooShort: function () {
                    return "Busca una marca...";
                  },

                noResults: function() {

                  return "Sin resultados";
                },
                searching: function() {

                  return "Buscando..";
                }
              },

              templateResult: formatRepoS,
              templateSelection: formatRepoSelectionS
        });

        function formatRepoS (repo) {

            if (repo.loading) {
              return repo.text;
            }

  

   var $container = $(
       "<div style='' class='select2-result-repository clearfix'>" +
       "<div>" + repo.nombre +" </div>"+
       "</div>"
   );



              return $container;
            }

function formatRepoSelectionS  (repo) {
              return repo.text || repo.nombre;
            }


            //Fin select2 marcas

       },
      preConfirm: (respuesta) =>{
  
        data = {
  
          "nombre":         $("#nombre").val(),
          "telefono":       $("#telefono").val(),
          "correo":         $("#correo").val(),
          "rfc":            $("#rfc").val(),
          "descripcion":    $("#descripcion").val()
        };
  
        if( data["nombre"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#nombre").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un nombre`
          )
        }else if( data["telefono"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#telefono").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un telefono`
          )
        }
      }
      //Si el resultado es OK tons:
    }).then((result) => {
  
     if(result.isConfirmed){
  
       var form = $("#agregar-proveedor")[0];
       var datos = new FormData(form);
       //datos.append("clase", tabla);
       descripcion = $("#direccion").val();
       datos.append("direccion", descripcion);
  
  
      $.ajax({
        type: "POST",
        url: "../servidor/proveedores/agregar-proveedor.php",
        data:datos,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        success: function(response) {
          if (response==1) {
            Swal.fire(
              "¡Correcto!",
              "Se agrego el producto",
              "success"
              ).then((result) =>{
  
                if(result.isConfirmed){
                   table.ajax.reload(null, false);
                }else if(result.isDenied){
                 table.ajax.reload(null, false);
                }
                });
  
          }else{
            Swal.fire(
              "¡Error!",
              "No se agrego el producto",
              "error"
              )
              console.log(response);
             table.ajax.reload(null, false);
          }
  
  
  
        },
        failure: function (response) {
            Swal.fire(
            "Error",
            "El producto no fue agregado.", // had a missing comma
            "error"
            )
        }
    });
  
  
     }
  
  },
  function (dismiss) {
    if (dismiss === "cancel") {
      swal.fire(
        "Cancelled",
          "Se cancelo la operacion",
        "error"
      )
    };
  })
  
  
  
  }
  