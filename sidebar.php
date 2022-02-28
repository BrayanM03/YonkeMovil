
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
        <a href="#">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Panel</span>
        </a>
        <span class="tooltip">Panel</span>
      </li>
     
     <li class="list-item">
       <a href="#">
         <i class='bx bx-store' ></i>
         <span class="links_name">Yonkes</span>
       </a>
       <span class="tooltip">Yonkes</span>
     </li>
     <li class="list-item">
       <a href="#">
         <i class='bx bx-wrench' ></i>
         <span class="links_name">Talleres</span>
       </a>
       <span class="tooltip">Talleres</span>
     </li>
     <li class="list-item">
       <a href="#">
         <i class='bx bx-flag' ></i>
         <span class="links_name">Mapa</span>
       </a>
       <span class="tooltip">Mapa</span>
     </li>
     <li class="list-item">
       <a href="#collapse-inv" class="collapsible">
         <i class='bx bx-folder' ></i>
         <span class="links_name">Inventario</span>
       </a>
       <div id="collapse-inv" class="content-collapse">
       <ul>
       <li class="list-item">
       <a href="#">
         <i class='bx bx-car' ></i>
         <span class="links_name">Vehiculos</span>
       </a>
       <span class="tooltip">Vehiculos</span>
     </li>
     <li class="list-item">
       <a href="#">
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
       <a href="#">
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
             <div class="job">Desarrollador web</div>
           </div>
         </div>
         <i class='bx bx-log-out' id="log_out" ></i>
     </li>
    </ul>
  </div>