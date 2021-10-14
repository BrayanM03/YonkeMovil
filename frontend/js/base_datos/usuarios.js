function MostrarUsuarios() {  
    $.fn.dataTable.ext.errMode = 'none';

    table = $('#tabla-usuarios').DataTable({
      
    serverSide: false,
    ajax: {
        method: "POST",
        url: "./app/backend/base_datos/traer-usuarios.php",
        dataType: "json"
 
    },  

  columns: [   
    { title: "#",              data: null             },
    { title: "Nombre",          data: "nombre" , width: "20%"},
    { title: "Usuario",         data: "usuario" },
    { title: "Contraseña",            data: "contraseña"},
    { title: "fecha",            data: "fecha"},
    { title: "rol",            data: "rol"},
   // { title: "sucursal",            data: "sucursal"},
    { title: "puesto",            data: "puesto"},
    { title: "Accion",
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

$("table.dataTable thead").addClass("table-info")

 //Enumerar las filas "index column"
 table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
       
    } );
} ).draw();

}

MostrarUsuarios();

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




function agregarUsuario() {


    Swal.fire({
      title: "Agregar usuario nuevo",
      html: '<form class="mt-4" id="agregar-proveedor" autocomplete="new-password">'+ 
  
  
          '<div class="col-12">'+
          '<div class="form-group">'+
          '<label><b>Nombre: </b></label>'+
          '<input id="nombre" class="form-control" type="text" placeholder="Nombre completo">'+
          '</div>'+
          '</div>'+

       '</div>'+
        
            '<div class="row">'+
          
                  '<div class="col-12">'+
                  '<div class="form-group">'+
                  '<label><b>Usuario</b></label>'+  
                  '<input id="usuario" class="form-control" type="text" placeholder="Usuario" autocomplete="new-password">'+
                  '<div class="invalid-feedback">Ya existe un usuario con ese nombre.</div>'+
              '</div>'+
            '</div>'+
            '<div class="col-12">'+
                  '<div class="form-group">'+
                  '<label><b>Contraseña</b></label>'+

                '<div class="input-group">'+
                '<input id="contraseña" class="form-control" type="password" placeholder="Contraseña" autocomplete="new-password">'+
                
                '<div class="input-group-append">'+
                '<button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>'+
                '</div>'+
                '<div class="invalid-feedback" id="feedback-pass"></div>'+
                '</div>'+

            '</div>'+
            '</div>'+
          '<div class="col-12 col-md-6">'+
                '<div class="form-group">'+
                '<label><b>Rol</b></label>'+
                '<select type="text" class="form-control m-auto" onchange="asignarYonke(this);" name="rol" id="rol" >'+
                '<option value="0">Administrador</option>'+
                '<option value="1">Usuario de Yonke</option>'+
                '</select>'+
                '</div>'+
          '</div>'+

          '<div class="col-12 col-md-6">'+
                '<div class="form-group">'+
                '<label>Puesto:</label>'+
                '<input type="text" class="form-control" id="puesto" placeholder="Puesto..."></input>'+         
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
      showCancelButton: true,
      cancelButtonText: 'Cerrar',
      cancelButtonColor: '#00e059',
      showConfirmButton: true,
      confirmButtonText: 'Agregar',
      cancelButtonColor:'#ff764d',
      focusConfirm: false,
      iconColor : "#36b9cc",
      showLoaderOnConfirm: true,
      didOpen: function () { 


                  //Validar por medio de keyup el $stockInventario
            $("#contraseña").keyup(function () {
              
              contraseña_valor=  $("#contraseña").val();    

              //validar longitud contraseña
              if ( contraseña_valor.length < 6 ) {
                $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback");
            }
            //validar letra
            if ( contraseña_valor.match(/[A-z]/) ) {
                $('#contraseña').removeClass('is-invalid').addClass('is-valid');
                $("#feedback-pass").text("Nivel de seguridad: medio").removeClass().addClass("valid-feedback");
            } else {
                $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback");
            }

            //validar letra mayúscula
            if ( contraseña_valor.match(/[A-Z]/) ) {
                $('#contraseña').removeClass('is-invalid').addClass('is-valid');
                $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("valid-feedback");
            } else {
                $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback")
            }


            //validar numero
            if ( contraseña_valor.match(/\d/) ) {
                $('#contraseña').removeClass('is-invalid').addClass('is-valid');
                
                $("#feedback-pass").text("Nivel de seguridad: medio").removeClass().addClass("valid-feedback");
            } else {
                $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                
                $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback");
            }

            
            if(contraseña_valor.length > 6 && contraseña_valor.match(/[A-z]/) && contraseña_valor.match(/[A-Z]/) && contraseña_valor.match(/\d/)){
            
              $('#contraseña').removeClass('is-invalid').addClass('is-valid');
              $("#feedback-pass").text("Nivel de seguridad: alto").removeClass().addClass("valid-feedback");

            }
            });

         $("#usuario").keyup(function() {

                  usuario_validar = $(this).val();
                

                  $.ajax({
                    type: "POST",
                    url: "./app/backend/base_datos/validar-usuarios.php", 
                    data:{"usuario": usuario_validar},
                  
                    success: function(response) {
                      if(response == 1){
                        flag = $("#usuario").hasClass("is-invalid");
                        if(flag == true){

                        $("#usuario").removeClass("is-invalid");
                          $("#usuario").addClass("is-valid");
                          $("#usuario").attr("validar", "valid");
                        }else{
                            $("#usuario").addClass("is-valid");
                        }

                      }else if(response == 2){
                        flag = $("#usuario").hasClass("is-valid");
                        if(flag == true){
                          $("#usuario").removeClass("is-valid");
                          $("#usuario").addClass("is-invalid");
                          $(".invalid-feedback").text("Ya hay un usuario con ese nombre.");
                          $("#usuario").attr("validar", "invalid");

                        }else{
                            $("#usuario").addClass("is-invalid");
                            $(".invalid-feedback").text("No se puede cantidad en 0")
                            $("#usuario").attr("validar", "invalid");
                        }
                      }else if(response == 3){
                        flag = $("#usuario").hasClass("is-valid");
                        if(flag == true){
                          $("#usuario").removeClass("is-valid");
                          $("#usuario").addClass("is-invalid");
                          $(".invalid-feedback").text("Dato vacio.")
                          $("#usuario").attr("validar", "invalid");
                        }else{
                            $(".invalid-feedback").text("Dato vacio.")
                        }
                      }

                    }

                  });

                });

       },
      preConfirm: (respuesta) =>{
  
        data = {
  
          "nombre":        $("#nombre").val(),
          "usuario":       $("#usuario").val(),
          "contraseña":    $("#contraseña").val(),
          "rol":           $("#rol").val(),
          "puesto":        $("#puesto").val()
        };
  
        if( data["nombre"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#nombre").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un nombre`
          )
        }else if( data["usuario"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#usuario").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un usuario`
          )
        }else if( data["contraseña"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#contraseña").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece una contraseña`
          )
        }else if( data["puesto"] == ""){
          $(".datoVacio").removeClass("datoVacio");
          $(".border-danger").removeClass("border-danger");
          $("#puesto").addClass("border-danger");
          Swal.showValidationMessage(
            `Establece un puesto`
          )
        }else if($("#rol").val() == 1){
          console.log("rol");
          if($("#buscador-yonke").attr("yonke") == null){
            console.log("cuak");
            $(".datoVacio").removeClass("datoVacio");
            $(".border-danger").removeClass("border-danger");
            $("#buscar-yonke").addClass("border-danger");
            Swal.showValidationMessage(
              `Asgina un yonke a este usuario.`
            )
          }
        
        }else if($("#usuario").attr("validar")=="invalid"){
          console.log("rol");
          if($("#buscador-yonke").attr("yonke") == null){
            console.log("cuak");
            $(".datoVacio").removeClass("datoVacio");
            $(".border-danger").removeClass("border-danger");
            $("#buscar-yonke").addClass("border-danger");
            Swal.showValidationMessage(
              `Este usuario ya existe, intenta otro.`
            )
          }
        
        }
      }
      //Si el resultado es OK tons:
    }).then((result) => {
  
     if(result.isConfirmed){
  
      
  
        nombre_usuario=        $("#nombre").val();
        username=              $("#usuario").val();
        pass_usuario=          $("#contraseña").val();
        rol_usuario=           $("#rol").val();
        puesto_usuario=        $("#puesto").val();
      
        yonkes_escogidos =$("#buscar-yonke").val();
  
      $.ajax({
        type: "POST",
        url: "./app/backend/base_datos/agregar-nuevo-usuario.php",
        data:{"nombre": nombre_usuario, "usuario": username, "contraseña": pass_usuario, "rol": rol_usuario, "puesto": puesto_usuario, "yonkes" : yonkes_escogidos},
        success: function(response) {
          if (response==1) {
            Swal.fire(
              "¡Correcto!",
              "Se registro el usuairo",
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
  
  });
  
  }



  