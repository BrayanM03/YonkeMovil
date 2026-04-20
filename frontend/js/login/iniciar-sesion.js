function iniciarSesion() {
    
   const username = $("#username").val();
   const password = $("#password").val();


   $.ajax({

    method: "POST",
    url: "./backend/login/iniciar-sesion.php",
    data: {"username": username, "password": password},
    dataType: "json",

    success: function (response) {
        const estado = Number(response.estado || 0);
        const rol = Number(response.rol || 0);

        if(estado === 1){
            if(rol === 1){
                window.location = "./panel_cliente.php";
            }else{
                window.location = "./index.php";
            }
        }else if(estado === 3){
            Swal.fire(
                "¡Contraseña erronea!",
                "Valida la contraseña.",
                "error"
                );
        }else if(estado === 2){
            Swal.fire(
                "¡Usuario inexistente!",
                "Ups, parece que el usuario no existe.",
                "error"
                );
        }else if(estado === 4){
            Swal.fire(
                "Usuario desactivado",
                "Tu cuenta no esta activa, contacta al administrador.",
                "warning"
                );
        }else{
            Swal.fire(
                "Error de acceso",
                response.mensaje || "No se pudo iniciar sesion.",
                "error"
                );
        }
    }

   });


}


function mostrarPassword(){

    var cambio = document.getElementById("password");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }
