<?php
    session_start();
    date_default_timezone_set("America/Matamoros");
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "maaaaal";
    }

    if ($_POST) {
    
        $nombre = $_POST["nombre"];
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        $fecha = date("Y-m-d"); 
        $rol = $_POST["rol"];
        $puesto = $_POST["puesto"];
        $sucursal =$_POST["sucursal"];
        $id_sucursal = $_POST["yonke_id"];
        

        $query = "INSERT INTO usuarios (id, nombre, usuario, contraseña, fecha, rol, sucursal, id_sucursal, puesto ) VALUES (null,?,?,?,?,?,?,?,?)";
        $resultado = $con->prepare($query);
        $resultado->bind_param('ssssssss', $nombre, $usuario, $contraseña, $fecha, $rol, $sucursal, $id_sucursal, $puesto );
        $resultado->execute();
        $resultado->close();
        print_r(1);

    }
    ?>
