//$.fn.selectpicker.Constructor.BootstrapVersion = '4';

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
                          url: "./backend/usuarios/validar-usuarios.php", 
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
      
                      //MOstrar contraseña
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







                      //Funcion que hara aprecer el select2 para asignar yonkes 
function asignarYonke(opcion){

    if($("#rol").val() == 0){
      $("#buscador-yonke").empty(); 
    }else{
  
      $("#buscador-yonke").empty();
      $("#buscador-yonke").append('<label>Asignar Yonke:</label>'+
      '<select class="form-control" id="buscar-yonke" name="yonkes[]" multiple="multiple">'+
       
      '</select>');
  
      /* $('#buscar-yonke').selectpicker(); */

     /*  $(".input-block-level").keyup(function () {
        $("#buscador-yonke").empty();     
        string=  $(this).val(); 
        console.log(string);

        //Aqui estaba la funcion  sleect23
        var datos = new FormData();
        datos.append("searchTerm", string);
      fetch('./backend/usuarios/buscar-yonke.php', {
        method: 'POST',
        body: datos
    }).then(function (response) { 
        return response.json();
        
     }).then(function(data){
       
         $("#buscar-yonke").empty();

        data.forEach(element => {
            console.log(element.nombre);
             $(".dropdown-menu").append('<li data-original-index="'+ element.id +'" class="">'+
                 '<a tabindex="0" class="" data-normalized-text="<span class=&quot;text&quot;>'+ element.nombre +'</span>">'+
                     '<span class="text">'+ element.nombre +'</span><span class="glyphicon">'+
                    '</span>'+
                '</a></li>');
         });

         $('#buscar-yonke').selectpicker();
     })
    
        });  */ 
  
      
  
      
  
  
      $("#buscar-yonke").select2({
        placeholder: "Busca un yonke...",
        theme: "bootstrap",
        minimumInputLength: 0,
        ajax: {
            url: "./backend/usuarios/buscar-yonke.php",
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

  


function agregarUsuario(){

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
      
      }else{
        
  
  nombre_usuario=        $("#nombre").val();
  username=              $("#usuario").val();
  pass_usuario=          $("#contraseña").val();
  rol_usuario=           $("#rol").val();
  puesto_usuario=        $("#puesto").val();

  yonkes_escogidos =$("#buscar-yonke").val();

$.ajax({
  type: "POST",
  url: "./backend/usuarios/agregar-nuevo-usuario.php",
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

}
  



