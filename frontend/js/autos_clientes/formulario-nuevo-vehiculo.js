
document.documentElement.style.setProperty('--animate-duration', '.3s');

function mostrarFormularioNuevoVehiculo(){

    let home_section = $(".home-section");

    home_section.empty(); 

    home_section.append('<div class="contenedor-principal m-3">'+
    '<div class="row">'+
        '<div class="col-12 col-md-12 text-center mt-3">'+
            '<h4>Ingresar nuevo auto</h4>'+
            '<p>Selecciona el año, el modelo y la marca del auto para agregarla a tu inventario.</p>'+
        '</div>'+
      '</div>'+

      '<div class="row justify-content-center">'+
          '<div class="col-12 col-md-10 p-3">'+
              '<div class="btn btn-success item-con-icono" onclick="RegresaralInventario()"><i class="bx bx-border bx-arrow-back"></i> | Regresar al inventario</div>'+
         '</div>'+
      '</div>'+

      '<div class="row justify-content-center">'+
          '<div class="col-12 col-md-8 p-3">'+
                '<div class="card p-3">'+
                '<div class="row justify-content-center">'+
                    '<div class="col-12 col-md-4">'+
                        '<label for="yonke-elegido"><b>Agregar a:</b></label>'+
                        '<select class="form-control" id="yonke-elegido">'+
                        '</select>'+
                        '</div>'+
                        '<div class="col-12 col-md-2">'+
                        '<label for="cantidad"><b>Cantidad</b></label>'+
                        '<input type="text" placeholder="0" class="form-control" id="cantidad">'+
                    '</div>'+
                '</div>'+
                    '<div class="row mt-3">'+
                        '<div class="col-12 col-md-4">'+
                            '<div class="form-group">'+
                                '<label><b>Año</b></label>'+
                                '<select class="form-control" id="año_select">'+
                                    '<option value="1930">1930</option>'+
                                    '<option value="1931">1931</option>'+
                                    '<option value="1932">1932</option>'+
                                    '<option value="1933">1933</option>'+
                                    '<option value="1934">1934</option>'+
                                    '<option value="1935">1935</option>'+
                                    '<option value="1936">1936</option>'+
                                    '<option value="1937">1937</option>'+
                                    '<option value="1938">1938</option>'+
                                    '<option value="1939">1939</option>'+
                                    '<option value="1940">1940</option>'+
                                    '<option value="1941">1941</option>'+
                                    '<option value="1942">1942</option>'+
                                    '<option value="1943">1943</option>'+
                                    '<option value="1944">1944</option>'+
                                    '<option value="1945">1945</option>'+
                                    '<option value="1946">1946</option>'+
                                    '<option value="1947">1947</option>'+
                                    '<option value="1948">1948</option>'+
                                    '<option value="1949">1949</option>'+
                                    '<option value="1950">1950</option>'+
                                    '<option value="1951">1951</option>'+
                                    '<option value="1952">1952</option>'+
                                    '<option value="1953">1953</option>'+
                                    '<option value="1954">1954</option>'+
                                    '<option value="1955">1955</option>'+
                                    '<option value="1956">1956</option>'+
                                    '<option value="1957">1957</option>'+
                                    '<option value="1958">1958</option>'+
                                    '<option value="1959">1959</option>'+
                                    '<option value="1960">1960</option>'+
                                    '<option value="1961">1961</option>'+
                                    '<option value="1962">1962</option>'+
                                    '<option value="1963">1963</option>'+
                                    '<option value="1964">1964</option>'+
                                    '<option value="1965">1965</option>'+
                                    '<option value="1967">1967</option>'+
                                    '<option value="1968">1968</option>'+
                                    '<option value="1969">1969</option>'+
                                    '<option value="1970">1970</option>'+
                                    '<option value="1971">1971</option>'+
                                    '<option value="1972">1972</option>'+
                                    '<option value="1973">1973</option>'+
                                    '<option value="1974">1974</option>'+
                                    '<option value="1975">1975</option>'+
                                    '<option value="1976">1976</option>'+
                                    '<option value="1977">1977</option>'+
                                    '<option value="1978">1978</option>'+
                                    '<option value="1979">1979</option>'+
                                    '<option value="1980">1980</option>'+
                                    '<option value="1981">1981</option>'+
                                    '<option value="1982">1982</option>'+
                                    '<option value="1983">1983</option>'+
                                    '<option value="1984">1984</option>'+
                                    '<option value="1985">1985</option>'+
                                    '<option value="1986">1986</option>'+
                                    '<option value="1987">1987</option>'+
                                    '<option value="1988">1988</option>'+
                                    '<option value="1989">1989</option>'+
                                    '<option value="1990">1990</option>'+
                                    '<option value="1991">1991</option>'+
                                    '<option value="1992">1992</option>'+
                                    '<option value="1993">1993</option>'+
                                    '<option value="1994">1994</option>'+
                                    '<option value="1995">1995</option>'+
                                    '<option value="1996">1996</option>'+
                                    '<option value="1997">1997</option>'+
                                    '<option value="1998">1998</option>'+
                                    '<option value="1999">1999</option>'+
                                    '<option value="2000">2000</option>'+
                                    '<option value="2001">2001</option>'+
                                    '<option value="2002">2002</option>'+
                                    '<option value="2003">2003</option>'+
                                    '<option value="2004">2004</option>'+
                                    '<option value="2005">2005</option>'+
                                    '<option value="2006">2006</option>'+
                                    '<option value="2007">2007</option>'+
                                    '<option value="2008">2008</option>'+
                                    '<option value="2009">2009</option>'+
                                    '<option value="2010">2010</option>'+
                                    '<option value="2011">2011</option>'+
                                    '<option value="2012">2012</option>'+
                                    '<option value="2013">2013</option>'+
                                    '<option value="2014">2014</option>'+
                                    '<option value="2015">2015</option>'+
                                    '<option value="2016">2016</option>'+
                                    '<option value="2017">2017</option>'+
                                    '<option value="2018">2018</option>'+
                                    '<option value="2019">2019</option>'+
                                    '<option value="2020">2020</option>'+
                                    '<option value="2021">2021</option>'+
                                    '<option value="2022">2022</option>'+

                                '</select>'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-12 col-md-4">'+
                        '<div class="form-group">'+
                            '<label><b>Marca</b></label>'+
                            '<select class="form-control" id="marca_select" disabled>'+
                              
                            '</select>'+
                        '</div>'+
                        '</div>'+

                    
                    '<div class="col-12 col-md-4">'+
                    '<div class="form-group">'+
                        '<label><b>Modelo</b></label>'+
                        '<select class="form-control" id="modelo_select" disabled>'+ 
                        '</select>'+
                    '</div>'+
                    '</div>'+

                    '</div>'+

                  
                    //Cuerpo del card
                    '<div class="row justify-content-center">'+
                        '<div class="col-12 col-md-3 mt-5">'+
                            '<div class="add-images">'+
                                '<img src="./frontend/recursos/img/add.png" style="width:40px"></img>'+
                                '<span class="span-add-image text-center">Agregar fotos del auto</span>'+
                                '<span class="span-add-image-bottom text-center">No agregues mas de 5 imagenes.</span>'+
                            '</div>'+
                            '<input type="file" id="imagen-auto" name="imagen-auto[]" accept="image/jpeg" style="display:none" multiple>'+       
                        '</div>'+
                    '</div>'+

                    //Area del preoload
                    '<div class="row justify-content-center">'+
                        '<div class="col-12 col-md-12">'+
                            //Contenedor del previsualizador de imagenes
                            '<div id="preview-images" class="mt-3">'+        
                            '</div>'+

                            '<div class="preload">'+
                                '<img src="./frontend/recursos/img/preload.gif" style="width:70px;" alt="preload"/>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+

                    //Area del boton de agregar auto
                    '<div class="row justify-content-center">'+
                        '<div class="col-12 col-md-3 mt-5">'+
                            '<div class="add-vehicle">'+
                                '<div class="btn btn-outline-danger disabled" id="add-vehicule-client">Agregar auto</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+

                '</div>'+
          '</div>'+
      '</div>'+
  '</div>');


  //Traer yonkes del usuario
  user_id = $("#profile-details").attr("sesion_id");
  $.ajax({
    type: "POST",
    url: "./backend/yonkes/traer-yonkes-cliente.php",
    data: {"user_id": user_id},
    dataType: "JSON",
    success: function (response) {
     
      response.forEach(element => {
          console.log(element.nombre);

          $("#yonke-elegido").append(`
                <option value="${element.id_yonke}">${element.nombre}</option>
              `)

      });
      
      
    }
  });

 
  //Mandar a llamar los autos las marcas del año en cuestion
  $('#año_select').on('change', function() {
   año = this.value;
   let select_modelo = $("#modelo_select");

   $.ajax({
       type: "POST",
       url: "./backend/autos_clientes/traer_marca_select.php",
       data: {"año": año},
       dataType: "JSON",
       success: function (response) {
        
                let select_marca = $("#marca_select");
                select_marca.select2();
                $(".select2-selection--single").css("height", "35px")

                if(response.length == 0){
                    console.log("No hay resultados");
                    select_marca.empty();
                    select_marca.prop("disabled");
                    select_modelo.empty();
                    select_modelo.prop("disabled");

                    let disabled_check = $("#add-vehicule-client").hasClass("disabled");
                         if(disabled_check==false){
                            $("#add-vehicule-client").addClass("disabled")
                         }
                }else{

                   //En caso de devolver una respuesta OK entoces se agregar las <option> a la lista desplegable de las marcas
                    select_marca.prop("disabled", "");
                    select_marca.empty();
                    response.forEach(element => {
                       
                        select_marca.append('<option value="'+ element.marca +'">' + element.marca + '</option>');
                       

                    });

                };
            

       }
   });

  });

  //Mandar a llamar los modelos de las marcas del año en cuestion
  $('#marca_select').on('change', function() {
        marca = this.value;
        año = $('#año_select').val();
        $.ajax({
            type: "POST",
            url: "./backend/autos_clientes/traer_modelo_select.php",
            data: {"marca": marca,"año": año},
            dataType: "JSON",
            success: function (response) {
             
                     let select_modelo = $("#modelo_select");
                     select_modelo.select2({
                        placeholder: 'Selecciona un modelo'
                     });

                     $(".select2-selection--single").css("height", "35px")
     
                     if(response.length == 0){
                         console.log("No hay resultados");
                         select_modelo.empty();
                     }else{
                        
                        //En caso de devolver una respuesta OK entoces se agregar las <option> a la lista desplegable de las marcas
                         select_modelo.prop("disabled", "");
                         let disabled_check = $("#add-vehicule-client").hasClass("disabled");
                         if(disabled_check==true){
                            $("#add-vehicule-client").removeClass("disabled")
                         }
                               
                         select_modelo.empty();
                         response.forEach(element => {
                            
                             select_modelo.append('<option value="'+ element.modelo +'">' + element.modelo + '</option>');
                            
     
                         });
     
                     };
                 
     
            }
        });
     
       });


       //Clicear ara ejecutar funcion
$(".add-images").on("click", function () { 

    $("#imagen-auto").click();

 });

 $(".icono-add-image").on("click", function () { 

    $("#imagen-auto").click();

 });



 //Logica detrass del preload de las imagenes

 (function () {
     'use strict';
    
     var file = document.getElementById('imagen-auto');
     var formData = new FormData();
     var agregarAuto = document.getElementById('add-vehicule-client');
     var preload = document.querySelector('.preload');
     


     file.addEventListener('change', function (e) {

         for (let i = 0; i < file.files.length; i++) {

             var thumbnail_id = Math.floor(Math.random() * 30000) + '_' + Date.now();
             createThumbnail(file, i, thumbnail_id);
             formData.append(thumbnail_id, file.files[i]);

         }

         e.target.value = '';

        /*  $('.add-images').empty(); */
        // document.getElementById('preview-images').insertAdjacentHTML('beforeend', '<i class="icono-add-image bx bxs-message-square-add bx-tada-hover bx-lg"></i>');

     });

     //Funcion que crea los thumbnail images temp y las pinta en el DOM
     var createThumbnail = function (archivo, iterador, thumbnail_id) {
         var thumbnail = document.createElement('div');
         thumbnail.classList.add('thumbnail', thumbnail_id);
         
         thumbnail.dataset.id = thumbnail_id;

         thumbnail.setAttribute('style', `background-image: url(${URL.createObjectURL(archivo.files[iterador])})`);


         document.getElementById('preview-images').appendChild(thumbnail);

         createCloseButton(thumbnail_id);
         thumbnail.classList.add('animate__animated', 'animate__fadeInRight')
         console.log(formData);
         
     };

     //Funcion que crea los thumbnail-close images del DOM
     var createCloseButton = function (thumbnail_id) {

        var closeButton = document.createElement('div');
        closeButton.classList.add('close-button');
        closeButton.innerHTML = "<i class='bx bxs-x-circle remover'></i>";
        document.getElementsByClassName(thumbnail_id)[0].appendChild(closeButton);

       }

      

       //Funcion que borrara el form data y las imagenes
       var clearFormDataAndThumbnails = function () { 
            for (var key of formData.keys()) {
                formData.delete(key);
            }

            document.querySelectorAll('.thumbnail').forEach(function (thumbnail) { 
                thumbnail.classList.remove('animate__fadeInRight');
                thumbnail.classList.add('animate__backOutUp');
                thumbnail.remove();
             });


        }

       //Evento que eliminara la img
       document.body.addEventListener('click', function (e) { 
    
           if(e.target.classList.contains('remover')){
               
                 e.target.parentNode.parentNode.classList.remove('animate__fadeInRight');
                 e.target.parentNode.parentNode.classList.add('animate__fadeOutDown');
                
                 setInterval(borrarData, 350);

                 function borrarData(){
                    e.target.parentNode.parentNode.remove(); 
                    formData.delete(e.target.parentNode.parentNode.dataset.id);
                 }
                
           }

          

        })

        //Evento que subira las imagenes a la database ------------------******
        agregarAuto.addEventListener('click', function (e) { 

            e.preventDefault();
            //Activamos el preload
            preload.classList.add('activate-preload');

            var marca = document.getElementById('marca_select').value;
            var año = document.getElementById('año_select').value;
            var modelo = document.getElementById('modelo_select').value;
            var yonke_id = document.getElementById('yonke-elegido').value;
            var cantidad = document.getElementById('cantidad').value;

            formData.append('año', año);
            formData.append('marca', marca);
            formData.append('modelo', modelo);
            formData.append('yonke_id', yonke_id);
            formData.append('cantidad', cantidad);

            fetch('./backend/autos_clientes/subir_auto.php', {
                method: 'POST',
                body: formData
            }).then(function (response) { 
                return response.json();
                clearFormDataAndThumbnails();
             }).then(function (data) { 
                 preload.classList.remove('activate-preload');
                 clearFormDataAndThumbnails();
                 console.log(data);

                 if(data == 1){
                    Swal.fire(
                        "¡Correcto!",
                        "Se registro una nueva unidad en el inventario",
                        "success"
                        )
                        clearFormDataAndThumbnails();
                 }
              }).catch(function (err) { 
                  console.log(err);
               })

         });


         

     
 })();


}



