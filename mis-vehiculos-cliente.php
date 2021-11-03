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
    <link rel="stylesheet" href="frontend/css/formulario-nuevo-vehiculo.css">
    
    <link rel="icon" href="frontend/recursos/icon/favicon.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
      .select2 {
                width:100%!important;
                }
    </style>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<div class="sidebar">

    <div class="logo-details">
     <!--  <i class='bx bxl-c-plus-plus icon'></i> -->
        <img class="logo_img" src="frontend/recursos/img/YonkeMovil_logo_back.png" alt="">
        <div class="logo_name">YonkeMovil</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list" id="lista-navegacion">
      <li class="list-item">
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Buscar..."> 
         <span class="tooltip">Buscar</span>
      </li>
    
      <li class="list-item item-con-icono">
       <a href="panel_cliente.php">
       <i class='bx bxs-layout'></i>
         <span class="links_name">Panel de cliente</span>
       </a>
       </li>
       
     <li class="list-item">
       <a href="#collapse-inv" class="collapsible">
         <i class='bx bx-folder'></i>
         <span class="links_name">Inventario</span>
       </a>
       <div id="collapse-inv" class="content-collapse">
       <ul>
       <li class="list-item item-con-icono">
       <a href="mis-vehiculos-cliente.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Mis Vehiculos</span>
       </a>
       <span class="tooltip">Vehiculos</span>
     </li>
     <li class="list-item item-con-icono">
       <a href="mis-partes-cliente.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Mis Partes</span>
       </a>
       <span class="tooltip">Partes</span>
     </li>
       </ul>
       
       </div>
       <span class="tooltip">Inventario</span>
     </li class="list-item">
     
     
    
     <li class="list-item item-con-icono" style="margin-bottom: 40%;">
       <a href="configuraciones.php">
         <i class='bx bx-cog' ></i>
         <span class="links_name">Configuraciones</span>
       </a>
       <span class="tooltip">Configuraciones</span>
     </li>
    </ul>
    <ul>
    <li class="profile">
         <div class="profile-details">
           <img src="frontend/recursos/img/pp/<?php echo $_SESSION["username"] ?>.jpg" alt="profileImg">
           <div class="name_job">
             <div class="name"><?php echo $_SESSION['nombre']; ?></div>
             <div class="job"><?php echo $_SESSION['puesto']; ?></div>
           </div>
         </div>
         <a href="backend/login/cerrar-sesion.php"><i class='bx bx-log-out' id="log_out" ></i></a>
     </li>
    </ul>
  </div>

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
          <div class="col-12 col-md-10 p-3">
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

</body>
</html>
