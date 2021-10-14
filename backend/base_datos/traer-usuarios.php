<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../../login.php");
}


if (isset($_POST)) {
       
    
    $query="SELECT * FROM usuarios";

    $resultado = mysqli_query($con, $query);

    while($fila = $resultado->fetch_assoc()){
    $id= $fila["id"];
   // $codigo = $fila["codigo"];
    $nombre = $fila["nombre"];
    $usuario = $fila["usuario"];
    $contraseña = $fila["contraseña"];
    $fecha = $fila["fecha"];
    $rol = $fila["rol"];
 //   $sucursal = $fila["sucursal"];
    $puesto = $fila["puesto"];
   // $transmicion = $fila["transmicion"];

    $data["data"][] = array("id" => $id, "nombre" => $nombre,
                    "usuario"=>$usuario, "contraseña"=>$contraseña,"fecha"=>$fecha, "rol"=> $rol, "puesto"=>$puesto);

                  
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);  

}else{
    print_r("No se pudo establecer una conexión");
}


?>
