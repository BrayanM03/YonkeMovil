<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../login.php");
}


if (isset($_POST)) {
       
    
    $query="SELECT * FROM yonkes";

    $resultado = mysqli_query($con, $query);

    while($fila = $resultado->fetch_assoc()){
    $id= $fila["id"];
    $nombre = $fila["nombre"];
    $contacto = $fila["contacto"];
    $numero = $fila["numero"];
    $direccion= $fila["direccion"];
    $fecha_reg = $fila["fecha_reg"];
    $estatus = $fila["estatus"];

    $data["data"][] = array("id" => $id, "nombre" => $nombre,
                    "contacto"=>$contacto, "numero"=>$numero,"direccion"=>$direccion, "fecha_reg"=> $fecha_reg, "estatus"=> $estatus);

                  
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);  

}else{
    print_r("No se pudo establecer una conexión");
}


?>
