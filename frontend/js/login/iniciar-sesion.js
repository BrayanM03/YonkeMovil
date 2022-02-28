function iniciarSesion() {
    
   const username = $("#username").val();
   const password = $("#password").val();


   $.ajax({

    method: "POST",
    url: "./backend/login/iniciar-sesion.php",
    data: {"username": username, "password": password},

    success: function (response) {
        if(response ==1){
            window.location = "./index.php";
        }else if(response ==0){
            Swal.fire(
                "¡Contraseña erronea!",
                "Valida la contraseña.",
                "error"
                );
        }else if(response ==2){
            Swal.fire(
                "¡Usuario inexistente!",
                "Ups, parece que el usuario no existe.",
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