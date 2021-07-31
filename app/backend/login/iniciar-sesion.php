<?php

 include 'conexion.php';
 $con = $conectando->conexion();

 

   if(isset($_POST)){

    $username = $_POST["username"];
    $password = $_POST["password"];
    

    $query_mostrar = $con->prepare("SELECT * FROM usuarios WHERE usuario =?");
    $query_mostrar->bind_param('s', $username);
    $query_mostrar->execute();
    $query_mostrar->store_result();    
    $rows= $query_mostrar->num_rows();

    if ($rows > 0 ) {
        $query_mostrar->bind_result($id, $nombre, $user, $pass, $date, $rol, $sucursal, $id_sucursal, $puesto);
        $query_mostrar->fetch();
        $validar_pass = password_verify($password, $pass);
        if ($validar_pass) {

            session_start();
            
            $_SESSION['id'] = $id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['username'] = $user;
            $_SESSION['fecha'] = $date;
            $_SESSION['rol'] = $rol;
            $_SESSION['sucursal'] = $sucursal;
            $_SESSION['id_sucursal'] = $id_sucursal;
            $_SESSION['puesto'] = $puesto;


            print_r(1); //credenciales validas
        }else{
            print_r(0); //Contraseña erronea
        }
    }else{
        print_r(2); //Usuario inexsistente
    }
 
   }


?>