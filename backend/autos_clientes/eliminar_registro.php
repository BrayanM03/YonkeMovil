<?php
session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión";
    }

    $id = $_POST['id'];
    $user_session_id = $_SESSION['id'];

    $borrar_reg = "DELETE FROM inventario_cliente_$user_session_id WHERE id = ?";
    $resultado = $con->prepare($borrar_reg);
    $resultado->bind_param("i", $id);
    $resultado->execute();
    $resultado->close();

    $res = array("mensj"=>true);
    echo json_encode($res, JSON_UNESCAPED_UNICODE);

    ?>