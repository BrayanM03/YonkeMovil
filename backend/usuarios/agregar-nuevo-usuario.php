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
        $contraseña_cifrada = password_hash($contraseña, PASSWORD_BCRYPT);
        $fecha = date("Y-m-d"); 
        $rol = $_POST["rol"];
        $puesto = $_POST["puesto"];
      //  $sucursal =$_POST["sucursal"];
       // $id_sucursal = $_POST["yonke_id"];
       if(isset($_POST["yonkes"])){ 
        $array_yonkes = $_POST["yonkes"];
       }


       //Validar si el usuario es de tipo Yonkero

    /*    if ($rol == 1) {
           # code...
       } */
      
        

        

        $query = "INSERT INTO usuarios (id, nombre, usuario, contraseña, fecha, rol, puesto ) VALUES (null,?,?,?,?,?,?)";
        $resultado = $con->prepare($query);
        $resultado->bind_param('ssssss', $nombre, $usuario, $contraseña_cifrada, $fecha, $rol, $puesto);
        $resultado->execute();
        $resultado->close();

        $traer = "SELECT id FROM usuarios WHERE usuario LIKE ?";
        $resultado = $con->prepare($traer);
        $resultado->bind_param('s', $usuario);
        $resultado->execute();
        $resultado->bind_result($usuario_id);
        $resultado->fetch();
        $resultado->close(); 

        if($rol == 1){

            foreach ($array_yonkes as &$yonke_id) {
                $query = "INSERT INTO detalle_yonke (id, id_usuario, id_yonke, fecha) VALUES (null,?,?,?)";
                $resultado = $con->prepare($query);
                $resultado->bind_param('sss', $usuario_id, $yonke_id, $fecha);
                $resultado->execute();
                $resultado->close();
            }
        }

        print_r(1);

    }
    ?>
