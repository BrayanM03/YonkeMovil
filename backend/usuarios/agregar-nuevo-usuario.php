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

            //Creanndo ruta para guardar imagenes
            $micarpeta = '../../frontend/recursos/img/base_datos/carpeta_user_'. $usuario_id;
            if (!file_exists($micarpeta)) {
                mkdir($micarpeta, 0777, true);
                $micarpetaYonke = '../../frontend/recursos/img/base_datos/carpeta_user_'. $usuario_id;
                if (!file_exists($micarpetaYonke)) {
                    mkdir($micarpetaYonke, 0777, true);
                }
            }


            foreach ($array_yonkes as &$yonke_id) {
                $query = "INSERT INTO detalle_yonke (id, id_usuario, id_yonke, fecha) VALUES (null,?,?,?)";
                $resultado = $con->prepare($query);
                $resultado->bind_param('sss', $usuario_id, $yonke_id, $fecha);
                $resultado->execute();
                $resultado->close();

                /* $micarpetaYonkes = '../../frontend/recursos/img/base_datos/carpeta_user_'. $usuario_id . '/yonkes/yonke_id_'.$yonke_id;
                if (!file_exists($micarpetaYonkes)) {
                    mkdir($micarpetaYonkes, 0777, true);
                    
                } */

              
            }

                /*Creamos la tabla del inventario de cliente
                $tabla = "inventario_cliente_" . $usuario_id;
                $crear_tabla = "CREATE TABLE $tabla (
                    id int NOT NULL PRIMARY KEY,
                    año int,
                    modelo VARCHAR(150),
                    marca VARCHAR(150),
                    stock int,
                    estatus VARCHAR(60),
                    fecha varchar(100),
                    id_yonke int
                    
                );";
                $result = $con->prepare($crear_tabla);
                $result->execute();
                $result->close();

                */
        }

        print_r(1);

       }else{

        print_r(2);


       }
        

        

    }
    ?>
