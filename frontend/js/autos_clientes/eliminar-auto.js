

 function eliminarRegistro(id) {

 btn = $("#reg_"+id);
 icon = $("#icon_"+id);
 btn.empty();
 btn.append("<i class='bx bx-loader-circle bx-spin'></i>");
 
 Swal.fire({
  icon: "info",
  title: "Elminar registro",
  html: "<span>¿Desea eliminar este registro?</span>",
  showConfirmButton: true,
  showCancelButton: true

 }
  ).then(function(response) {
    if (response.isConfirmed){

        $.ajax({
          type: "POST",
          url: "./backend/autos_clientes/eliminar_registro.php",
          data: {"id":id},
          dataType: "JSON",
          success: function (response) {
            if(response.mensj == true){
              table.ajax.reload(null, false);
            }
          }
        });

        Swal.fire(
          "¡Correcto!",
          "Se elimino el registro",
          "success"
        );
        btn.empty();
        btn.append("<i class='fa fa-trash'></i>")
    }else{
        btn.empty();
        btn.append("<i class='fa fa-trash'></i>")
      
    }
  })

}

