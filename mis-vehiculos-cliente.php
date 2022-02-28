<?php

include 'backend/login/conexion.php';
 $con = $conectando->conexion();

 session_start();

 if(empty($_SESSION["id"])){
    header("Location:login.php");
    die();
 }


 

?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="es" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Inventario de vehiculos | YonkeMovil </title>
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/@fortawesome/fontawesome-free/css/all.min.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="frontend/css/style-navbar.css">
    
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="frontend/css/formulario-nuevo-vehiculo.css"> 
    
    <link rel="icon" href="frontend/recursos/icon/favicon.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
      .select2 {
                width:100%!important;
                }
    </style>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<?php
require_once("navbar.php");
?>

<section class="home-section">

  <div class="contenedor-principal m-3">
    <div class="row">
        <div class="col-12 col-md-12 text-center mt-3">
            <h4>Mi inventario de autos</h4>
            <p>Registra los autos que tienes disponibles, estos son los que encontrara la gente en el buscador principal.</p>
        </div>  
      </div>

      <div class="row justify-content-center">
          <div class="col-12 col-md-10 p-3" >
              <div class="btn btn-success item-con-icono" onclick="mostrarFormularioNuevoVehiculo()"> <i class='bx bx-car bx-border'></i> | Agregar vehiculo</div>
          </div>
      </div>

      <div class="row justify-content-center">
          <div class="col-12 col-md-3 p-3" >
              <select class="form-control" id="lista-yonke"></select>
          </div>
      </div>

      <div class="row justify-content-center">
          <div class="col-12 col-md-8 p-3">
                <table id="tabla_autos_cliente" class="table table-striped" style="background-color: white;"></table>
          </div>
      </div>
  </div>
  </section>


    <script type="text/javascript" src="frontend/node_modules/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script src="frontend/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!----Mis librerias----->
    <script src="frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="frontend/js/script-navbar.js"></script>
    <script src="frontend/js/autos_clientes/mis-autos-cliente.js"></script>
    <script src="frontend/js/autos_clientes/formulario-nuevo-vehiculo.js"></script>
    <script src="frontend/js/autos_clientes/image-preload.js"></script>
    <script src="frontend/js/autos_clientes/inventario-cliente.js"></script>


</body>
</html>
