//opciones de las alertas
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }


  //Traer información y plantarla en el cliente
id_usuario = $("#usuario").attr("this_id_user");
contador = 1; 
nuevoToken = Math.floor((Math.random() * (9999 - 1000) + 1000));

    $.ajax({
        type: "POST",
        url: "./backend/usuarios/traer-info-usuario.php",
        data: {"id_user": id_usuario},
        dataType: "JSON",
        success: function (response) {
        
            $("#nombre").val(response.nombre);
            $("#usuario").val(response.usuario);
            $("#puesto").val(response.puesto);
            $("#rol").val(response.rol);
            $(".foto-perfil").attr("id", response.id);
            $(".foto-perfil").css("background-image", "url('./frontend/recursos/img/pp/"+ response.usuario +".jpg?"+ nuevoToken +".0.0')")
            //$("#nombre").val(response.nombre);
            
        }
    });


//Funciones para validar    

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


  $("#usuario").keyup(function() {

    usuario_validar = $(this).val();
    
 
    $.ajax({
      type: "POST",
      url: "./backend/usuarios/validar-usuarios-agregado.php", 
      data:{"usuario": usuario_validar, "this_user": id_usuario},
    
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
          flag = $("#usuario").hasClass("is-invalid");
          if(flag == true){
            $("#usuario").removeClass("is-invalid");
            $("#usuario").addClass("is-valid");
            $("#usuario").attr("validar", "valid");
          }else{
              $(".invalid-feedback").text("Dato vacio.")
          }
        }
        if(response == 4){
            flag = $("#usuario").hasClass("is-valid");
            if(flag == true){
              $("#usuario").removeClass("is-valid");
              $("#usuario").addClass("is-invalid");
              $(".invalid-feedback").text("Ingresa un nombre de usuario");
              $("#usuario").attr("validar", "invalid");
    
            }else{
                $("#usuario").addClass("is-valid");
                $("#usuario").attr("validar", "valid");
            }
        }

      }

    });

  });


  //Funcion hover para foto de perfil

  function transparent() {  
    
    texto = $("#texto-pp");
    flag = texto.hasClass("blanco");
    foto_perfil = $(".foto-perfil");

    if (flag == true) {
        texto.removeClass("blanco");
        texto.css("color", "transparent");  
        foto_perfil.css("filter", "brightness(1)");
              
    }else{
        foto_perfil.css("filter", "brightness(0.6)");
        texto.addClass("blanco");
        texto.css("color", "white");
    
    }
  }

  //Actualizar foto de perfil

  function updatepp() { 
     
         
    archivo = document.getElementById('archivo');

    function obtenerImagen(){

        //cargar imagen********************************************
        imagen = new Image;
        imagen.onload = ()=>{
            console.log('imagen cargada!')
            dibujarImagenes();
        }
        imagen.src = URL.createObjectURL(archivo.files[0]);
        /******************************************************* */
    }
    
    Swal.fire({
        title: "Actualizar foto de perfil",
        html: '<div class ="row mt-4">'+
              '<div class="col-12 col-md-12">'+
              '<img id="imagenMostrada">'+
              '<canvas id="canvas" class="mb-3" width="300" height="300"></canvas>'+
                '<label class="btn btn-info" id="archivoFile" for="archivo">Seleccionar foto</label>'+
                '<input type="file" id="archivo">'+
              '</div>'+ 
              '</div>',
        showCancelButton: true,
        cancelButtonText: 'Cerrar',
        cancelButtonColor: '#00e059',
        showConfirmButton: true,
        confirmButtonText: 'Agregar',
        cancelButtonColor:'#ff764d',
        focusConfirm: false,
        iconColor : "#36b9cc",
       // showLoaderOnConfirm: true,
        didOpen: function() { 
  
            
            archivo = document.getElementById('archivo');
            canvas = document.getElementById('canvas');
            context = canvas.getContext('2d');
            archivoBtn = document.getElementById('archivoFile');
            archivo.addEventListener("change", obtenerImagen, false);

            /*function darClick() { 
                archivo.click();
             } */

            function obtenerImagen(){

                //cargar imagen********************************************
                imagen = new Image;
                imagen.onload = ()=>{
                    console.log('imagen cargada!')
                    dibujarImagenes();
                }
                imagen.src = URL.createObjectURL(archivo.files[0]);
                /******************************************************* */
            }

            function dibujarImagenes(){

                //Parar el mainLoop anterior
                if(window.mainLoop !== null)
                {
                    //console.log('PARO!')
                    clearInterval(window.mainLoop)
                }
            
                //Dibujar imagen por primera vez**************************
                var px = (canvas.width - imagen.width) / 2//Posicion x inicial en el medio
                var py = (canvas.height - imagen.height) / 2//Posicion y inicial en el medio
                var sx = imagen.width;//tamano de imagen en x
                var sy = imagen.height;//tamano de imagen en y
            
                //Si la imagen es muy grande la encogemos un poco
                if(sx > 350 || sy > 350)
                {
                    sx = sx * 0.7
                    sy = sy * 0.7;
            
                    px = (canvas.width - sx) / 2;
                    py = (canvas.height - sy) / 2;
                }else if(sx < 200 || sy < 200)//Agrandamos la imagen si es muy pequena
                {
                    sx = sx * 1.7
                    sy = sy * 1.7;
            
                    px = (canvas.width - sx) / 2;
                    py = (canvas.height - sy) / 2;
                }
                context.fillStyle = 'darkgray';
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.drawImage(imagen, px, py, sx, sy);
                //****************************************************** */
            
                //Mover imagen:****************************************************
                var presionando = false
                var moviendo = false;
            
                canvas.onmousedown = (event)=>{
                    presionando = true
                }
            
                canvas.onmouseup = (event)=>{
                    presionando = false;
                    moviendo = false
                    contador = 0;//Recargamos el contador
                }
            
                var intervalo;
                var mx = 0;//posicion del mouse en x
                var my = 0;//posicion del mouse en y
            
                var pdx = 0;//posicion delta del mouse en x
                var pdy = 0;//posicion delta del mouse en y;
                var amx = 0;//posicion anterior del mouse en x
                var amy = 0;//posicion anterior del mouse en y
                var contador = 0;//Se necesita para obtener la posicion inicial cuando se empieza el swipeo
                canvas.onmousemove = (event)=>{
            
                    clearInterval(intervalo);
                    moviendo = true;
                    mx = event.clientX;
                    my = event.clientY;
                    intervalo = setInterval(()=>{moviendo = false;}, 1000/60)
                }
            
                /************************************************************* */
            
                window.mainLoop = setInterval(()=>{
                    
                    if(presionando == true && moviendo == true)
                    {
                        //Obtenemos la posicion actual del mouse el rpimer frame
                        if(contador == 0)
                        {
                            amx = px;
                            amy = py;
                        }
                    
                        if(contador > 1)
                        {
                            //Calculamos la posicion delta del mouse y se lo agregamos a la posicion de la imagen
                            pdx = mx - amx;
                            pdy = my - amy;
                            px += pdx;
                            py += pdy;
            
                            //Limpiamos el canvas y dibujamos la imagen con la nueva posicion
                            context.fillStyle = 'darkgray';
                            context.fillRect(0, 0, canvas.width, canvas.height);
                            context.drawImage(imagen, px, py, sx, sy);
                            
                        }
                        amx = mx;
                        amy = my;
                        contador++;
                    }
                }, 1000/60)//60 = 60FPS
                /************************************************************** */
            
                //Resizar imagen
                var porcentajeResizado = 0.1;//Se usa para scalar la imagen sin perder el aspect ratio

                canvas.addEventListener("wheel", function(event){
                    if(event.deltaY == 100)
                    {
                        //console.log('para abajo')
                        //limitamos al usuario para que no haga la imagen demasiado pequena
                        if(sx > canvas.width || sy > sy.height)
                        {
                            //Calcular el nuevo size de la imagen y ponerla en el centro
                            sx -= sx * porcentajeResizado;
                            sy -= sy * porcentajeResizado;
                            px = (canvas.width - sx) / 2;
                            py = (canvas.height - sy) / 2;
                            /******************************************************** */
                            context.fillStyle = 'darkgray';
                            context.fillRect(0, 0, canvas.width, canvas.height);
                            context.drawImage(imagen, px, py, sx, sy);
                        }
                        
                    }else
                    {
                        //Calcular el nuevo size de la imagen y ponerla en el centro
                        sx += sx * porcentajeResizado;
                        sy += sy * porcentajeResizado;
                        px = (canvas.width - sx) / 2;
                        py = (canvas.height - sy) / 2;
                        /********************************************************** */
                        context.fillStyle = 'darkgray';
                        context.fillRect(0, 0, canvas.width, canvas.height);
                        context.drawImage(imagen, px, py, sx, sy);
                        //console.log('para arriba');
                       console.log("evente Y: "+ event.deltaY);
                       console.log("evente X: "+ event.deltaX);
                    }
                    //console.log(event);
                }, false);
            
                
            }
            
            
  
         },
        
        //Si el resultado es OK tons:
      }).then((result) => {

        if (result.isConfirmed) {
            
           var id_user = $(".foto-perfil").attr("id");

            canvas.toBlob((blob)=>{
                ruta = URL.createObjectURL(blob);
                var dataURL = canvas.toDataURL();
                
              /*   imagenAMostrar.setAttribute('src', URL.createObjectURL(blob));
                imagenAMostrar.style.display = 'block'; */
                
                $.ajax({
                    type: "POST",
                    url: "./backend/usuarios/cambiar-foto-perfil.php",
                    data: {"imgBase64": dataURL, "id_user": id_user},
                   
                    success: function (response) {
                       
                        contador = contador + 1;   
                          
                        $(".foto-perfil").css("background-image", "url('./frontend/recursos/img/pp/"+ response +".jpg?1."+ contador +".0')")
                        Swal.fire(
                            "¡Correcto!",
                            "Se actualizó foto de perfil",
                            "success"
                            )
                    }
                });
            })
        }
      
   });

}


//Actualizar datos usuarios
function updateinfo(tipo) { 
    var id_user = $(".foto-perfil").attr("id");

    switch (tipo) {
            
            case "nombre":
            nombre = $("#nombre").val();
            enviarData(tipo, nombre);
            break;

            case "usuario":
            usuario = $("#usuario").val();
            validacion = $("#usuario").hasClass("is-valid");
            console.log(validacion);
            if (validacion == true) {
                enviarData(tipo, usuario);
            }else if (validacion == false) {
                toastr.error('Información invalida', 'Error'); 
            }else{
                enviarData(tipo, usuario); 
            }
            break;    
            case "contraseña":
            contraseña = $("#contraseña").val();
            enviarData(tipo, contraseña);
            break;

            case "puesto":
            puesto = $("#puesto").val();
            enviarData(tipo, puesto);    
            break;

            case "rol":
            rol = $("#rol").val();
            enviarData(tipo, rol);        
            break;

        default:
            console.log("Tipo de dato desconocido");
            break;
    }

    function enviarData(tipo, dato) { 
        $.ajax({
            type: "POST",
            url: "./backend/usuarios/update-info-users.php",
            data: {"campo": tipo, "dato": dato, "id_user": id_user},
            //dataType: "dataType",
            success: function (response) {
                if (response ==1) {
                    toastr.success('Actualizado correctamente', 'Correcto');   
                }
            }
        });
     }

 }

 //Asignar yonke

 function asignarYonke(opcion){

    if($("#rol").val() == 1 || $("#rol").val() == 3){
      $("#buscador-yonke").empty(); 
      $("#new-guardar").empty();
    }else{

      $("#buscador-yonke").empty();
      $("#buscador-yonke").append('<label><b>Asignar Yonke:</b></label>'+
      '<select class="form-control" id="buscar-yonke"  name="yonkes[]" multiple="multiple"></select>');

      $("#new-guardar").append('<div class="btn btn-success btn-sm">Guardar</div>');
 
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

