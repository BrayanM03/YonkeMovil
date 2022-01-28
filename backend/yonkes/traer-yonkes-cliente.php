<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../login.php");
}

    $id_user = $_SESSION["id"];
    $traer = "SELECT COUNT(*) FROM detalle_yonke WHERE id_usuario =?";
    $result = $con->prepare($traer);
    $result->bind_param('s', $id_user);
    $result->execute();
    $result->bind_result($total);
    $result->fetch();
    $result->close();


    if($total > 0) {
        $consulta = "SELECT * FROM detalle_yonke WHERE id_usuario = $id_user";
        $resultado = mysqli_query($con, $consulta);

        while($fila = $resultado->fetch_assoc()){
           
            $id_yonke = $fila["id_yonke"];

            $traer = "SELECT COUNT(*) FROM yonkes WHERE id =?";
            $result = $con->prepare($traer);
            $result->bind_param('s', $id_yonke);
            $result->execute();
            $result->bind_result($total_yonkes);
            $result->fetch();
            $result->close();

            if($total_yonkes > 0){

                $traer = "SELECT nombre FROM yonkes WHERE id =?";
                $result = $con->prepare($traer);
                $result->bind_param('s', $id_yonke);
                $result->execute();
                $result->bind_result($nombre);
                $result->fetch();
                $result->close();

                $response[] = array("id_yonke"=>$id_yonke, "nombre"=>$nombre);

            }else{
                $response = array("mensaje"=> "No se encontro ningun Yonke con el id del detalle de Yonke, compruebe la base de datos.");
                echo json_encode($response);
            }

           

        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

    }else{
        $response = array("mensaje"=> "No se encontro ningun Yonke para este usuario");
        echo json_encode($response);
    }

?>