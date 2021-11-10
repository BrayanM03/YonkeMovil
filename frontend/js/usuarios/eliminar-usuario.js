function borrarUsuario(id){

    Swal.fire({
        icon: "warning",
        title: "Eliminar usuario",
        html: '<span>¿Esta seguro de eliminar este usuario?<br> Esta accion no se puede deshacer.</span>',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({
                type: "POST",
                url: "./backend/usuarios/eliminar_usuario.php",
                data: {"usuario_id": id},
                dataType: "JSON",
                success: function (response) {
                    table.ajax.reload(null,false);
                    Swal.fire({
                        icon: "success",
                        title: "El usuario se borro correctamente",
                        html: '<span>'+ response.mensaje +'</span>',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar'
                    })

                }
            });

        }

    })

}