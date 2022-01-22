
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
       <a href="panel_cliente.php">
       <i class='bx bxs-layout' ></i>
         <span class="links_name">Panel de cliente</span>
       </a>
       </li>

<<<<<<< HEAD
      <!--  <li class="list-item">
       <a href="yonkes-cliente.php">
       <i class='bx bxs-store' ></i>
         <span class="links_name">Yonkes</span>
       </a>
       </li> -->
=======
       <li class="list-item">
       <a href="yonkes-cliente.php" class="collapsible">
       <i class='bx bxs-store' ></i>
         <span class="links_name">Yonkes</span>
       </a>
          <!--<div id="collapse-yonkes" class="content-collapse">
          <ul id="lista-yonkes-cliente-navbar" id_sesion="<?php echo $_SESSION['id'] ?>">
                 <li class="list-item">
                <a href="mis-vehiculos-cliente.php">
                  <i class='bx bx-car'></i>
                  <span class="links_name">Mis Vehiculos</span>
                </a>
                <span class="tooltip">Vehiculos</span>
              </li>
              <li class="list-item">
                <a href="mis-partes-cliente.php">
                  <i class='bx bx-car'></i>
                  <span class="links_name">Mis Partes</span>
                </a>
                <span class="tooltip">Partes</span>
              </li> 
          </ul>
          
          </div>-->
       </li>
>>>>>>> 7b5cd3226e9dd982cee02862cb11721638440736
       
     <li class="list-item">
       <a href="#collapse-inv" class="collapsible">
         <i class='bx bx-folder'></i>
         <span class="links_name">Inventario</span>
       </a>
       <div id="collapse-inv" class="content-collapse">
       <ul>
       <li class="list-item">
       <a href="mis-vehiculos-cliente.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Mis Vehiculos</span>
       </a>
       <span class="tooltip">Vehiculos</span>
     </li>
     <li class="list-item">
       <a href="mis-partes-cliente.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Mis Partes</span>
       </a>
       <span class="tooltip">Partes</span>
     </li>
       </ul>
       <span class="tooltip">Inventario</span>
       </div>
       
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
         <div class="profile-details" id="profile-details" sesion_id="<?php echo $_SESSION['id'];?>">
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