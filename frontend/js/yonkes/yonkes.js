function MostrarYonkes() {  
    $.fn.dataTable.ext.errMode = 'none';

    table = $('#tabla-yonkes').DataTable({
      
    serverSide: false,
    ajax: {
        method: "POST",
        url: "./backend/yonkes/traer-yonkes.php",
        dataType: "json"
 
    },  

  columns: [   
    { title: "#",                    data: null             },
    { title: "Nombre",               data: "nombre" , width: "20%"},
    { title: "Contacto",             data: "contacto" },
    { title: "Numero tel",           data: "numero"},
    { title: "Direccion",            data: "direccion"},
    { title: "Fecha de registro",    data: "fecha_reg"},
    { title: "Estatus",              data: "estatus"},
    { title: "Accion",  
      data: null,
      className: "celda-acciones",
      render: function (row, data) {
        return `<div class="btn btn-primary m-1" onclick="verInventario(${row.id})"><i class="fa-solid fa-eye"></i></div>
                <div class="btn btn-danger m-1"><i class="fa-solid fa-trash"></i></div>`;
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

$("table.dataTable thead").css("background-color", "#1D1B31");
$("table.dataTable thead").css("color", "white");

 //Enumerar las filas "index column"
 table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
       
    } );
} ).draw();

}

MostrarYonkes();

function mostrarPassword(){

  var cambio = document.getElementById("contraseña");
  if(cambio.type == "password"){
    cambio.type = "text";
    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
  }else{
    cambio.type = "password";
    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
  }
} 


  
  function asignarYonke(opcion){

    if($("#rol").val() == 0){
      $("#buscador-yonke").empty(); 
    }else{

      $("#buscador-yonke").empty();
      $("#buscador-yonke").append('<label>Asignar Yonke:</label>'+
      '<select class="form-control" id="buscar-yonke"  name="yonkes[]" multiple="multiple"></select>');
 
      $("#buscar-yonke").select2({
       placeholder: "Busca un yonke...",
       theme: "bootstrap",
       minimumInputLength: 0,
       ajax: {
           url: "./app/backend/base_datos/buscar-yonke.php",
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
               return "Busca una yonke...";
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
  "<div style='width:100%;'><span style='margin-left:10px;'>" + repo.nombre +"</span> </div>"+
  "</div>"
 );
 
 
 
         return $container;
       }
 
 function formatRepoSelectionS  (repo) {
 
         $("#buscador-yonke").attr("yonke", repo.nombre);
         $("#buscador-yonke").attr("yonke_id", repo.id);
         return repo.text || repo.nombre;
       }
 
      
   

    }
     

  }




function agregarYonke() {


    Swal.fire({
      title: "Agregar Yonke nuevo",
      html: '<form class="mt-4" id="agregar-yonke" autocomplete="new-password">'+ 
  
  
          '<div class="col-12">'+
          '<div class="form-group">'+
          '<label><b>Nombre: </b></label>'+
          '<input id="nombre" class="form-control" type="text" placeholder="Nombre completo">'+
          '</div>'+
          '</div>'+

       '</div>'+
        
            '<div class="row mt-3">'+
          
                  '<div class="col-12">'+
                  '<div class="form-group">'+
                  '<label><b>Contacto</b></label>'+  
                  '<input id="contacto" class="form-control" type="text" placeholder="Contacto" autocomplete="new-password">'+
                  '<div class="invalid-feedback">Ya existe un usuario con ese nombre.</div>'+
              '</div>'+
            '</div>'+
            '<div class="col-12 col-md-6 mt-3">'+
                  '<div class="form-group">'+
                  '<label><b>Telefono</b></label>'+

                '<div class="input-group">'+
                '<input id="telefono" class="form-control" type="number" placeholder="Telefono" autocomplete="new-password">'+
                
                '<div class="input-group-append">'+
                '<div id="show_password" class="btn btn-primary" type="button"> <span class="fa fa-phone icon"></span> </div>'+
                '</div>'+
                '</div>'+

            '</div>'+
            '</div>'+

            '<div class="col-12 col-md-6 mt-3">'+
                '<div class="form-group">'+
                '<label><b>Estatus:</b></label>'+
                '<select class="form-control" id="estatus">'+
                '<option value="Activo">Activo</option>'+
                '<option value="Suspendido">Suspendido</option>'+  
                '</select>'+         
                '</div>'+
          '</div>'+



          '<div class="col-12 col-md-12 mt-3">'+
                '<div class="form-group">'+
                '<label><b>Direccion:</b></label>'+
                '<textarea class="form-control" id="direccion" placeholder="Direccion..."></textarea>'+         
                '</div>'+
          '</div>'+
        
                '</div>'+
            '</div>'+
        
            '<div class="row  mt-1">'+
            '<div class="col-12">'+
            '<div class="form-group" id="buscador-yonke">'+
            '</div>'+
            '</div>'+
            '</div>'+
                    '</div>'+
        '</form>',
      width: "500px",
      showCancelButton: true,
      cancelButtonText: 'Cerrar',
      cancelButtonColor: '#00e059',
      showConfirmButton: true,
      showCloseButton: true,
      confirmButtonText: 'Agregar',
      cancelButtonColor:'#ff764d',
      focusConfirm: false,
      iconColor : "#36b9cc",
      showLoaderOnConfirm: true,
      didOpen: function () { 

       },
      preConfirm: (respuesta) =>{
  
        data = {
  
          "nombre":         $("#nombre").val(),
          "contacto":       $("#contacto").val(),
          "telefono":       $("#telefono").val(),
          "direccion":      $("#direccion").val()
              
          
        };
  
        if( data["nombre"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#nombre").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un nombre`
          )
        }else if( data["contacto"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#contacto").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un contacto`
          )
        }else if( data["telefono"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#telefono").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece una telefono`
          )
        }else if( data["direccion"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#direccion").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un direccion`
          )
        }
      }
      //Si el resultado es OK tons:
    }).then((result) => {
  
     if(result.isConfirmed){
  
      
  
        nombre_yonke=        $("#nombre").val();
        contacto=            $("#contacto").val();
        telefono=            $("#telefono").val();
        direccion=           $("#direccion").val();
        estatus=             $("#estatus").val(),

  
      $.ajax({
        type: "POST",
        url: "./backend/yonkes/agregar-nuevo-yonke.php",
        data:{"nombre": nombre_yonke, "contacto": contacto, "telefono": telefono, "direccion": direccion, "estatus": estatus},
        success: function(response) {
          if (response==1) {
            Swal.fire(
              "¡Correcto!",
              "Se registro el Yonke",
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
              "No se agrego el yonke",
              "error"
              )
              console.log(response);
             table.ajax.reload(null, false);
          }
        },
        failure: function (response) {
            Swal.fire(
            "Error",
            "El yonke no fue agregado.", // had a missing comma
            "error"
            )
        }
    }); 
     }
  
  });
  
  }



  