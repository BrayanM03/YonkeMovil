<?php
$id_usuario = $_GET["id"];
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

    <!-- Librerias de terceros -->
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" />

    <link rel="stylesheet" href="frontend/css/style-navbar.css">
    <link rel="stylesheet" href="frontend/css/editar-usuario.css">
    
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
            <h4>Editar usuario del sistema</h4>
            <p>Puedes editar la inforacion del usuario, al igual que su foto de perfil</p>
        </div>  
      </div>
     
      </div>
      <div class="row justify-content-center">
      <div class="col-sm-10">
                                                <div class="card">
                                                    <div class="card-header">
                                                     <h4></h4>
                                                    </div>
                                                    <div class="card-block">

                                                    <div class="container">
                                                    <div class="row">
                                                    <div class="col-12 col-md-8">
                                                        <form action="">
                                                            <div class="row">
                                                                <div class="col-8 col-md-8">
                                                                    <label for=""><b>Nombre:</b> </label>
                                                                    <input type="text" id="nombre" class="form-control" placeholder="Nombre completo">
                                                                </div>
                                                                <div class="col-3 mt-4">
                                                                    <div class="btn btn-success btn-sm" onclick="updateinfo('nombre');">Guardar</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-8 col-md-8">
                                                                    <label for=""><b>Usuario: </b></label>
                                                                    <input type="text" id="usuario" class="form-control" placeholder="Escribe un nombre de usuario" this_id_user = "<?php echo $id_usuario; ?>">
                                                                    <div class="invalid-feedback">Ya existe un usuario con ese nombre.</div>
                                                                </div>
                                                                <div class="col-3 mt-4">
                                                                    <div class="btn btn-success btn-sm" onclick="updateinfo('usuario');">Guardar</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mt-3">
                                                            <div class="col-8 col-md-8">
                                                                    
                                                                    <label for=""><b>Nueva contraseña:</b> </label>
                                                                    <div class="input-group">
                                                                    <input type="password" id="contraseña" class="form-control" placeholder="Nueva contraseña" autocomplete="new-password">
                                                                    <button id="show_password" class="btn btn-primary btn-sm" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                                                    
                                                                    </div>
                                                                    <div class="invalid-feedback" id="feedback-pass"></div>
                                                                </div>
                                                                <div class="col-3 mt-4">
                                                                    <div class="btn btn-success btn-sm" onclick="updateinfo('contraseña');">Guardar</div> 
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-8 col-md-8">
                                                                    <label for=""><b>Puesto: </b></label>
                                                                    <input type="text" id="puesto" class="form-control" placeholder="Escribe un puesto">
                                                                  
                                                                </div>
                                                                <div class="col-3 mt-4">
                                                                    <div class="btn btn-success btn-sm" onclick="updateinfo('puesto');">Guardar</div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-8 col-md-8">
                                                                    <label for=""><b>Rol: </b></label>

                                                                    <select type="text" onchange="asignarYonke(this);" id="rol" class="form-control">
                                                                       <option value="1">Administrador</option> 
                                                                       <option value="2">Usuario de yonke</option>
                                                                       <option value="3">Usuario normal</option>
                                                                    </select>

                                                                </div>
                                                                <div class="col-3 mt-4">
                                                                    <div class="btn btn-success btn-sm" onclick="updateinfo('rol');">Guardar</div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                            <div class="col-8 col-md-8">
                                                                <div class="form-group" id="buscador-yonke"></div>
                                                            </div>
                                                            <div class="col-3 mt-4" id="new-guardar">
                                                                   
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="col-3 col-md-4">
                                                        <div class="area-foto justify-content-center align-items-center" style="cursor: pointer;" onclick="updatepp();">
                                                        <div id="texto-pp" onmouseover="transparent(this)" onmouseout="transparent(this)"><b>Editar foto</b></div>
                                                            <div class="foto-perfil" onmouseover="transparent(this)" onmouseout="transparent(this)" style="border: 3px solid gray; border-radius:50%; width: 250px; height:250px;">
                                                           <!-- <img class="foto-perfil"  src="./app/frontend/img/pp/brayan.jpg" style="width:100%; border-radius:50%; height:100%;" alt="Foto de perfil">-->
                                                            
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                    </div>
                                                  
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
      </div>
  </div>

  </section>

    <!----Libreroas de terceros----->

    <script type="text/javascript" src="frontend/node_modules/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="frontend/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="frontend/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="frontend/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="frontend/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous"></script>
 


    <!----Mis librerias----->
  <script src="frontend/js/script-navbar.js"></script>
  <script src="frontend/js/usuarios/editar-usuarios.js"></script>
  


</body>
</html>
