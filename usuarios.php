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
    <title> Responsive Sidebar Menu  | CodingLab </title>
    <link rel="icon" href="frontend/recursos/icon/favicon.ico" type="image/x-icon">

    <!-- Librerias de terceros --><!-- 
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css"> -->
    <!-- CSS only -->
    <!-- 
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'> -->
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="frontend/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  
    <link rel="stylesheet" href="frontend/css/style-navbar.css">
    <link rel="stylesheet" href="frontend/css/usuarios/usuarios.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
      <li class="list-item">
        <a href="index.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Panel</span>
        </a>
        <span class="tooltip">Panel</span>
      </li>
     
     <li class="list-item">
       <a href="yonkes.php">
         <i class='bx bx-store' ></i>
         <span class="links_name">Yonkes</span>
       </a>
       <span class="tooltip">Yonkes</span>
     </li>
     <li class="list-item">
       <a href="talleres.php">
         <i class='bx bx-wrench' ></i>
         <span class="links_name">Talleres</span>
       </a>
       <span class="tooltip">Talleres</span>
     </li>
     <li class="list-item">
       <a href="mapa.php">
         <i class='bx bx-flag' ></i>
         <span class="links_name">Mapa</span>
       </a>
       <span class="tooltip">Mapa</span>
     </li>
     <li class="list-item">
       <a href="#collapse-inv" class="collapsible">
         <i class='bx bx-folder'></i>
         <span class="links_name">Inventario</span>
       </a>
       <div id="collapse-inv" class="content-collapse">
       <ul>
       <li class="list-item">
       <a href="mis-vehiculos.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Vehiculos</span>
       </a>
       <span class="tooltip">Vehiculos</span>
     </li>
     <li class="list-item">
       <a href="mis-partes.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Partes</span>
       </a>
       <span class="tooltip">Partes</span>
     </li>
       </ul>
       
       </div>
       <span class="tooltip">Inventario</span>
     </li class="list-item">
     
   
     <li class="list-item">
       <a href="usuarios.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Usuarios</span>
       </a>
       <span class="tooltip">Usuarios</span>
     </li>
     
    
     <li class="list-item" style="margin-bottom: 40%;">
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
            <h4 style="font-size: 20px;">Usuarios del sistema</h4>
            <p style="font-size: 14px;">Estos son los usuarios que se han registrado en la aplicaci??n</p>
        </div>  
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 p-3"  style="font-size: 14px;">
        <a href="agregar-usuario.php" style="text-decoration:none; color:white;">  
        <div class="btn btn-lg btn-danger"> Agregar usuario</div>
        </a>
        </div>
      </div>
      <div class="row justify-content-center">
          <div class="col-12 col-md-10 p-3">
          <table style="font-size: 14px;"width="80%" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0" id="tabla-usuarios" style="background-color: white;"></table>
          </div>
      </div>
  </div>

  </section>

    <!----Libreroas de terceros----->

    <script type="text/javascript" src="frontend/node_modules/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <!-- JavaScript Bundle with Popper -->
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>  
<  <script src="frontend/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/@fortawesome/fontawesome-free/css/all.min.css"> 
    <!-- Latest compiled and minified JavaScript -->




    <!----Mis librerias----->
  <script src="frontend/js/script-navbar.js"></script>
  <script src="frontend/js/usuarios/usuarios.js"></script>
  <script src="frontend/js/usuarios/eliminar-usuario.js"></script>
  


</body>
</html>
