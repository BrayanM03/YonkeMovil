//$.fn.selectpicker.Constructor.BootstrapVersion = '4';

                  //Validar por medio de keyup el $stockInventario
                  $("#contraseña").keyup(function () {
              
                    contraseña_valor=  $("#contraseña").val();    
      
                    //validar longitud contraseña
                    if ( contraseña_valor.length < 6 ) {
                      $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                      $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback");
                      $("#text-invalid-pass-input").text("Debes ser mas de 6 caracteres");
                  }

                  if ( contraseña_valor.length == 0) {
                    $('#contraseña').removeClass('is-valid').addClass('is-invalid');
                    $("#feedback-pass").text("Nivel de seguridad: bajo").removeClass().addClass("invalid-feedback");
                    $("#text-invalid-pass-input").text("Ingresa una contraseña");
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
  
                  $("#rol").on("change", function(){
                    
                    if($("#rol").val()==1){
                      $("#btn-register").empty().removeClass('btn-success').addClass('btn-primary').append("Siguiente");
                    }else{
                      $("#btn-register").empty().removeClass('btn-primary').addClass('btn-success').append("Agregar usuario");
                    }
                  })    


function agregarUsuario(){

    data = {
  
        "nombre":        $("#nombre").val(),
        "usuario":       $("#usuario").val(),
        "contraseña":    $("#contraseña").val(),
        "rol":           $("#rol").val(),
        "puesto":        $("#puesto").val()
      };

      nombre_usuario=        $("#nombre").val();
      username=              $("#usuario").val();
      pass_usuario=          $("#contraseña").val();
      rol_usuario=           $("#rol").val();
      puesto_usuario=        $("#puesto").val();
    
    
      if( data["nombre"] == ""){
        $(".datoVacio").removeClass("datoVacio");
        $(".border-danger").removeClass("border-danger");
        $("#nombre").addClass("is-invalid");
        
        animacion_test =$(".contenedor-principal").hasClass('animate__animated animate__shakeX');
        animacion_test ? $(".contenedor-principal").removeClass('animate__animated animate__shakeX') : $(".contenedor-principal").addClass('animate__animated animate__shakeX');

      }else if( data["usuario"] == ""){
        $(".datoVacio").removeClass("datoVacio");
        $(".border-danger").removeClass("border-danger");
        $("#usuario").addClass("is-invalid");
        $("#text-invalid-user-input").text("Ingresa un nombre de usuario");
        animacion_test =$(".contenedor-principal").hasClass('animate__animated animate__shakeX');
        animacion_test ? $(".contenedor-principal").removeClass('animate__animated animate__shakeX') : $(".contenedor-principal").addClass('animate__animated animate__shakeX');
        
      }else if( data["contraseña"] == ""){
        $(".datoVacio").removeClass("datoVacio");
        $(".border-danger").removeClass("border-danger");
        $("#contraseña").addClass("is-invalid");
        $("#text-invalid-pass-input").text("Ingresa una contraseña");

        animacion_test =$(".contenedor-principal").hasClass('animate__animated animate__shakeX');
        animacion_test ? $(".contenedor-principal").removeClass('animate__animated animate__shakeX') : $(".contenedor-principal").addClass('animate__animated animate__shakeX');

      }else if( data["puesto"] == ""){
        $(".datoVacio").removeClass("datoVacio");
        $(".border-danger").removeClass("border-danger");
        $("#puesto").addClass("is-invalid");
        $("#text-invalid-puesto-input").text("Ingresa una contraseña");
     
      }else if($("#rol").val() == 0){
       
        
        
        

  insertarRegistro(nombre_usuario, username, pass_usuario, rol_usuario, puesto_usuario);


      
      }else if($("#rol").val() == 1){

      asignarYonke(nombre_usuario, username, pass_usuario, rol_usuario, puesto_usuario)


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
  

//Validacion de formulario

$("#nombre").keyup(function(){

  nombre_inpt_val = $("#nombre").val();
  if( nombre_inpt_val !== ""){
    $("#nombre").removeClass("is-invalid");
    $("#nombre").addClass("is-valid");
  }else{
    $("#nombre").removeClass("is-valid");
    $("#nombre").addClass("is-invalid");
  };

});

//Funcion que registra el cliente
function insertarRegistro(nombre_usuario, username, pass_usuario, rol_usuario, puesto_usuario){

  $.ajax({
    type: "POST",
    url: "./backend/usuarios/agregar-nuevo-usuario.php",
    data:{"nombre": nombre_usuario, "usuario": username, "contraseña": pass_usuario, "rol": rol_usuario, "puesto": puesto_usuario},
    success: function(response) {
      
      if(response == 1){
        Swal.fire(
          "¡Correcto!",
          "Se registro el usuario",
          "success"
          )
      }else if(response == 2){
        Swal.fire(
          "¡Hubo un error!",
          "Ese usuario ya fue registrado",
          "error"
          )
      }
  
    },
  }); 

}


function asignarYonke(nombre_usuario, username, pass_usuario, rol_usuario, puesto_usuario){
  $arreglo = [nombre_usuario, username, pass_usuario, rol_usuario, puesto_usuario];
  console.log($arreglo);
  $("#contenedor-principal").empty();
  $("#contenedor-principal").append(`
  
  <div class="row">
  <div class="col-12 col-md-12 text-center mt-3">
      <h4 style="font-size: 20px;">Nuevo Yonke</h4>
      <p style="font-size: 14px;">Okey, ahora registra un yonke para este usuario</p>
  </div>  
</div>

<div class="row justify-content-center mt-3">
  <div class="col-12 col-md-5">
      <label for="nombre-yonke"><b>Nombre</b></label>
      <input id="nombre-yonke" class="form-control" type="text" placeholder="Nombre de la sucursal">
      <div class="invalid-feedback">Agrega un nombre</div>
  </div>
</div>

<div class="row justify-content-center mt-3">
<div class="col-12 col-md-5">
      <label for="contacto-yonke""><b>Contacto</b></label> 
      <input id="contacto-yonke" class="form-control" type="text" placeholder="Nombre de un contacto">
      <div class="invalid-feedback" id="text-invalid-user-input"></div>
  </div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-12 col-md-5">
   <label for="telefono-yonke"><b>Telefono</b></label>
    <input type="text" class="form-control" id="telefono-yonke" placeholder="Telefono">
  </div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-12 col-md-5">
          <label for="estatus-yonke"><b>Estatus</b></label>
          <input type="text" class="form-control" id="estatus-yonke" placeholder="Estatus"/>
  </div>
</div>


 <div class="row justify-content-center mt-3">
  <div class="col-12 col-md-5">
      <label id="direccion-yonke"><b>Direccion:</b></label>
      <textarea type="text" class="form-control" id="direccion-yonke" placeholder="Escribe la direccion del yonke..."></textarea>
      <div class="invalid-feedback" id="text-invalid-puesto-input">Contraseña insegura.</div> 
  </div>
</div>

<div class="row  mt-3">
  <div class="col-12 col-md-12 text-center">
      <div class="btn btn-primary btn-lg" onclick="agregarOtroYonke();">Registrar otro yonke</div>
      <div class="btn btn-success btn-lg" onclick="agregarUsuarioYonke();">Finalizar registro</div>
      <div id="area-ver"></div>
  </div>
</div>  

  `);
}


//Funciones para la lista de yonkes_encontrados

arreglosYonkes = [];
function agregarOtroYonke() {
  let nombre_yonke = $("#nombre_yonke").val();
  let contacto_yonke = $("#contacto_yonke").val();
  let telefono_yonke = $("#telefono_yonke").val();
  let estatus_yonke = $("#estatus_yonke").val();
  let direccion_yonke = $("#direccion_yonke").val();

  let datos = {
    "nombre_yonke": nombre_yonke,
    "contacto_yonke": contacto_yonke,
    "telefono_yonke": telefono_yonke,
    "estatus_yonke": estatus_yonke,
    "direccion_yonke": direccion_yonke
  }
  arreglosYonkes.push(datos);
  console.log(arreglosYonkes);

  $("#nombre_yonke").val("");
  $("#contacto_yonke").val("");
  $("#telefono_yonke").val("");
  $("#estatus_yonke").val("");
  $("#direccion_yonke").text("");

  $("#area-ver").empty().append(`
  <div class="btn btn-info btn-lg" onclick="verLista(${arreglosYonkes});">Ver lista</div>`);
}

function verLista(arreglosYonkes) {
  console.log(arreglosYonkes);
  Swal.fire({

    title: "Yonkes actuales",
    html: `
      <div class="row justify-content-center container">
          <div class="col-12 col-md-12">
              <div class="list-group">
              <a href="#" class="list-group-item list-group-item-action active">
                Cras justo odio
              </a>
              <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
              <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
              <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
              <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
            </div>
          </div>
      </div>
    `,
    showCloseButton: true,
    showConfirmButton: true,
    confirmButtonText: "Todo bien"

  });
  }


