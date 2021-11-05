<?php
session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión";
    }


    $numero_fotos_subidas =  count($_FILES);
    
    //Validamos si se mandaron fotos o no
    if ($numero_fotos_subidas == 0) {
        print_r("Data:" . $_POST["año"] . " " . $_POST["marca"] . " " . $_POST["modelo"] . " ");

        $query = "INSERT INTO usuarios (id, nombre, usuario, contraseña, fecha, rol, puesto ) VALUES (null,?,?,?,?,?,?)";
        $resultado = $con->prepare($query);
        $resultado->bind_param('ssssss', $nombre, $usuario, $contraseña_cifrada, $fecha, $rol, $puesto);
        $resultado->execute();
        $resultado->close();

    }else{

        //Verificamos si existe la carpeta unica de cliente
    if (!is_dir('../../frontend/recursos/img/base_datos/customer/cliente_' . $_SESSION['id'])) {
        mkdir('../../frontend/recursos/img/base_datos/customer/cliente_' . $_SESSION['id']);
     }
 
     $count = 0; //Creamos un contador para contar las subidas
     $data = (!file_exists('database.json') ? [] : json_decode( file_get_contents('database.json'))); //verificamos si existe nuestro JSON donde se almacenara la info de la update
 
     $writable = fopen('database.json', 'w'); //Lo creamos
 
 
     //Aqui recorremos la variable global FILES done verificamos si se movio el archivo a la carpeta unica del cliente
     foreach($_FILES as $key => $file){
 
         if (!move_uploaded_file($file['tmp_name'], '../../frontend/recursos/img/base_datos/customer/cliente_' . $_SESSION['id'] .'/'. $file['name'])) {
             
             return print_r( json_encode(['message' => 'No fue posible subir los archivos', 'status' => http_response_code(500)] ));
 
         }
 
         //Agregamos el id y el nombre del archivo img al arreglo $data
         array_push($data, [
             'id'=>$key,
             'file_name' => $file['name']
         ]);
 
         $count++; //Incrementamos el contador
 
 
     }
 
     //Vericiamos que el contador sea igual a la longitud de FILES
     if( $count == count($_FILES)){
         fwrite($writable, json_encode($data));
         fclose($writable);
 
         //Retornamos el JSON con la informacion de la subida
         return print_r(json_encode(  
             [
                 'message' => 'Se subieron ' . $count . ' fotos con exito. :)',
                 'status' => http_response_code(200),
                 $data
             ]
         ));
     }

    }
 
    

    ?>