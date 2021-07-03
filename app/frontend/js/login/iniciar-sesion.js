function iniciarSesion() {
    
   const username = $("#username").val();
   const password = $("#password").val();


   $.ajax({

    method: "POST",
    url: "./app/backend/login/iniciar-sesion.php",
    data: {"username": username, "password": password},

    success: function (response) {
        if(response ==1){
            window.location = "./index.php";;
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