<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../../login.php");
}


if (isset($_POST)) {
       
    
    $query="SELECT * FROM modelos_2021";

    $resultado = mysqli_query($con, $query);

    while($fila = $resultado->fetch_assoc()){
    $id= $fila["id"];
   // $codigo = $fila["codigo"];
    $modelo = $fila["modelo"];
    $marca = $fila["marca"];
    $año = $fila["año"];
   // $transmicion = $fila["transmicion"];

    $data["data"][] = array("id" => $id, /* "codigo"=>$codigo, */ "modelo" => $modelo,
                    "marca"=>$marca, "año"=>$año/*  "transmicion"=>$transmicion */);

                  
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);  

}else{
    print_r("No se pudo establecer una conexión");
}


?>
