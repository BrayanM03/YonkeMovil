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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css"><!-- 
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'> -->

   <link rel="stylesheet" type="text/css" href="frontend/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  
    <link rel="stylesheet" href="frontend/css/style-navbar.css">
    <link rel="stylesheet" href="frontend/css/usuarios/usuarios.css">

    <link rel="stylesheet" href="frontend/node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    
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

  <div class="contenedor-principal m-3" style="font-size: 14px;">
    <div class="row">
        <div class="col-12 col-md-12 text-center mt-3">
            <h4 style="font-size: 20px;">Agregar un usuario</h4>
            <p style="font-size: 14px;">Agregar un usuario en la aplicacion</p>
        </div>  
      </div>

      <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-5">
            <label for="nombre"><b>Nombre</b></label>
            <input id="nombre" class="form-control" type="text" placeholder="Nombre completo">
            <div class="invalid-feedback">Agrega un nombre</div>
        </div>
      </div>

      <div class="row justify-content-center mt-3">
      <div class="col-12 col-md-5">
            <label><b>Usuario</b></label> 
            <input id="usuario" class="form-control" type="text" placeholder="Usuario" autocomplete="new-password">
            <div class="invalid-feedback" id="text-invalid-user-input"></div>
        </div>
      </div>

      <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-5">
        <label><b>Contraseña</b></label>
            <div class="input-group">
            
            <input id="contraseña" class="form-control" type="password" placeholder="Contraseña" autocomplete="new-password">  
                 <div class="input-group-append">
                   <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()" style="height: 34px;"> <span class="fa fa-eye-slash icon"></span> </button>
                 </div>
            <div class="invalid-feedback" id="text-invalid-pass-input">Contraseña insegura.</div> 
            </div>
        </div>
      </div>

      <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-5">
                <label><b>Rol</b></label>
                <select type="text" class="form-control m-auto" onchange="asignarYonke(this);" name="rol" id="rol" >
                <option value="0">Administrador</option>
                <option value="1">Usuario de Yonke</option>
                </select>   
        </div>
      </div>


       <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-5">
            <label><b>Puesto:</b></label>
            <input type="text" class="form-control" id="puesto" placeholder="Puesto..."></input>
            <div class="invalid-feedback" id="text-invalid-puesto-input">Contraseña insegura.</div> 
        </div>
      </div>

      <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-5">
            <div id="buscador-yonke"></div>
        </div>
      </div>
    
      <div class="row  mt-3">
        <div class="col-12 col-md-12 text-center">
            <div class="btn btn-primary btn-lg" onclick="agregarUsuario();">Agregar usuario</div>
        </div>
      </div>        
               
                        
             
               
  </div>

  </section>

    <!----Libreroas de terceros----->

    <script type="text/javascript" src="frontend/node_modules/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
  <script src="frontend/js/usuarios/agregar-usuario.js"></script>
  


</body>
</html>
