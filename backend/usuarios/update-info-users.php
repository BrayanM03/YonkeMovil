<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../login.php");
}



switch ($_POST["campo"]) {

    case 'nombre':
        
            //Actualizamos información del usuario
            $nombre = $_POST["dato"];
            $id_user = $_POST["id_user"];
            $editar_llanta= $con->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
            $editar_llanta->bind_param('si', $nombre, $id_user);
            $editar_llanta->execute();
            $editar_llanta->close();
            print_r(1);
            break;
        
    case 'usuario':
        
            //Actualizamos información del usuario
            $usuario = $_POST["dato"];
            $id_user = $_POST["id_user"];
            $editar_llanta= $con->prepare("UPDATE usuarios SET usuario = ? WHERE id = ?");
            $editar_llanta->bind_param('si', $usuario, $id_user);
            $editar_llanta->execute();
            $editar_llanta->close();
            print_r(1);
            break;

    case 'contraseña':
        
            //Actualizamos información del usuario
            $contraseña = $_POST["dato"];
            $password_hash = password_hash($contraseña, PASSWORD_BCRYPT);
            $id_user = $_POST["id_user"];
            $editar_llanta= $con->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
            $editar_llanta->bind_param('si', $password_hash, $id_user);
            $editar_llanta->execute();
            $editar_llanta->close();
            print_r(1);
            break;
    
    case 'puesto':
        
                //Actualizamos información del usuario
                $puesto = $_POST["dato"];
                $id_user = $_POST["id_user"];
                $editar_llanta= $con->prepare("UPDATE usuarios SET puesto = ? WHERE id = ?");
                $editar_llanta->bind_param('si', $puesto, $id_user);
                $editar_llanta->execute();
                $editar_llanta->close();
                print_r(1);
                break;        
    case 'rol':
        
                    //Actualizamos información del usuario
                    $rol = $_POST["dato"];
                    $id_user = $_POST["id_user"];
                    $editar_llanta= $con->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
                    $editar_llanta->bind_param('si', $rol, $id_user);
                    $editar_llanta->execute();
                    $editar_llanta->close();
                    print_r(1);
                    break;        
    default:
        # code...
        break;
}

?>