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
        if(isset($_POST["yonkes"])){ 
            $array_yonkes = $_POST["yonkes"];
           }
      

       //Validar si el usuario es de tipo Yonkero

    /*    if ($rol == 1) {
           # code...
       } */
      
       $comprobar = "SELECT count(id) FROM usuarios WHERE usuario LIKE ?";
       $resultado = $con->prepare($comprobar);
       $resultado->bind_param('s', $usuario);
       $resultado->execute();
       $resultado->bind_result($usuarios_encontrados);
       $resultado->fetch();
       $resultado->close(); 

       if ($usuarios_encontrados == 0) {
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

               /*  $consultar_nombre_yonke = "SELECT nombre FROM yonkes WHERE id = ?";
                $resultado = $con->prepare($consultar_nombre_yonke);
                $resultado->bind_param('s', $yonke_id);
                $resultado->execute();
                $resultado->bind_result($nombre_yonke);
                $resultado->fetch();
                $resultado->close();
 */
               

            }
        }

        print_r(1);

       }else{

        print_r(2);


       }
        

        

    }
    ?>
