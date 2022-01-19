<?php

session_start();
include '../login/conexion.php';
$con= $conectando->conexion(); 

if (!isset($_SESSION['id'])) {
    header("Location:../../login.php");
}

    $id_user = $_POST["user_id"];
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
                $query_yonke = "SELECT * FROM yonkes WHERE id =$id_yonke";
                $resultado2 = mysqli_query($con, $query_yonke);
                $response =array();
                while($fila = $resultado2->fetch_assoc()){
                    
                    $id_y = $fila['id'];
                    $nombre = $fila['nombre'];
                    $contacto = $fila['contacto'];
                    $numero = $fila['numero'];
                    $direccion = $fila['direccion'];
                    $fecha_reg = $fila['fecha_reg'];
                    $estatus = $fila['estatus'];

                    $response[] = array("nombre"=>$nombre);
                }

                echo json_encode($response, JSON_UNESCAPED_UNICODE);

            }else{
                $response = array("mensaje"=> "No se encontro ningun Yonke con el id del detalle de Yonke, compruebe la base de datos.");
                echo json_encode($response);
            }

        }

    }else{
        $response = array("mensaje"=> "No se encontro ningun Yonke para este usuario");
        echo json_encode($response);
    }

?>