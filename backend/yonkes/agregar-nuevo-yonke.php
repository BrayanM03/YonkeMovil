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
        $contacto = $_POST["contacto"];
        $telefono = $_POST["telefono"];
        $fecha = date("Y-m-d"); 
        $direccion = $_POST["direccion"]; 
        $estatus = $_POST["estatus"];  

        

        $query = "INSERT INTO yonkes (id, nombre, contacto, numero, direccion, fecha_reg, estatus) VALUES (null,?,?,?,?,?,?)";
        $resultado = $con->prepare($query);
        if ($resultado) {
         
        $resultado->bind_param('ssssss', $nombre, $contacto, $telefono, $direccion, $fecha, $estatus);
        $resultado->execute();
        $resultado->close(); 
        print_r(1); 
        }else{
            print_r("ckldsmnfl");
        }

        

        /* $ruta = "../../frontend/recursos/img/base_datos/yonkes/name_" . $nombre . "_id_" . $yonke_id;
        if (!file_exists($ruta)) {
         
            mkdir($ruta, 077, true);
        } */

       
        

    }
    ?>
