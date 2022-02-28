<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Arabic;

session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión establecida";
    }

    if (!isset($_SESSION['id'])) {
        header("Location:../../login.php");
    }
    

    if ($_SESSION['rol'] != 0) {
        header("Location:../../not_found.php");
    }


    $id_usuario = $_POST["usuario_id"];

    $borrar_usuario = "DELETE FROM usuarios WHERE id = ?";
    $resultado = $con->prepare($borrar_usuario);
    $resultado->bind_param("i", $id_usuario);
    $resultado->execute();
    $resultado->close();
    
    $comprobar_detalle_yonke = "SELECT COUNT(id) FROM detalle_yonke WHERE id_usuario =?";
    $resultado = $con->prepare($comprobar_detalle_yonke);
    $resultado->bind_param('i', $id_usuario);
    $resultado->execute();
    $resultado->bind_result($total);
    $resultado->fetch();
    $resultado->close();

    if ($total > 0) {

        $borrar_detalle = "DELETE FROM detalle_yonke WHERE id_usuario = ?";
        $resultado = $con->prepare($borrar_detalle);
        $resultado->bind_param("i", $id_usuario);
        $resultado->execute();
        $resultado->close();
    }

    $mensaje = "El usuario se borró correctamente";

    $response = array("estatus"=> "OK", "mensaje" => $mensaje);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
