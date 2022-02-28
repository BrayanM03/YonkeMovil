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
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/@fortawesome/fontawesome-free/css/all.min.css"> 
    <link rel="stylesheet" href="frontend/css/style-navbar.css">
    <link rel="icon" href="frontend/recursos/icon/favicon.ico" type="image/x-icon">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
            <h4>Bienvendio al panel de cliente <?php echo $_SESSION["nombre"];?></h4>
            <p>Encuentra la información que ocupas</p>
        </div>  
      </div>
      
      </div>
      <div class="row justify-content-center">
          <div class="col-12 col-md-10 p-3">
         
          </div>
      </div>
  </div>
  </section>


    <script type="text/javascript" src="frontend/node_modules/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script src="frontend/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>


    <!----Mis librerias----->
    <script src="frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="frontend/js/script-navbar.js"></script>

</body>
</html>
