<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion();


    if (!$con) {
        echo "maaaaal";
    }

    if (!isset($_SESSION['username'])) {
    header("Location:../../login.php");
    }


    if ($_POST) {

           $validar_usuario = $_POST["usuario"];
           $this_user = $_POST["this_user"];

           if($validar_usuario == ""){ 
             print_r(4); //dato entrante vacio
           }else{
             //Contamos el stock actual de producto en la base de datos del inventario
             $contar = "SELECT COUNT(*) total FROM usuarios WHERE usuario LIKE ?";
             $resultado = $con->prepare($contar);
             $resultado->bind_param('s', $validar_usuario);
             $resultado->execute();
             $resultado->bind_result($usuarios_encontrados);
             $resultado->fetch();
             $resultado->close();


             if($usuarios_encontrados > 0){

                $contar = "SELECT usuario FROM usuarios WHERE usuario LIKE ?";
                $resultado = $con->prepare($contar);
                $resultado->bind_param('s', $validar_usuario);
                $resultado->execute();
                $resultado->bind_result($username_encontrado);
                $resultado->fetch();
                $resultado->close();

                $encontrar = "SELECT usuario FROM usuarios WHERE id LIKE ?";
                $resultado = $con->prepare($encontrar);
                $resultado->bind_param('s', $this_user);
                $resultado->execute();
                $resultado->bind_result($this_username);
                $resultado->fetch();
                $resultado->close();

                if($username_encontrado == $this_username){
                    print_r(3); //Encontramos el mismo nombre de usuario
                }else{
                    print_r(2); //Devolvemos 2 indicando que hay mas usuarios con ese nombre
                }

             } else{
               print_r(1); //Devolvemos 1 indicando todo correcto
             }
           }

}

?>
