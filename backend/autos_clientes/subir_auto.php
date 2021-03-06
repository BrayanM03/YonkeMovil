<?php
session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión";
    }


    $numero_fotos_subidas =  count($_FILES);
    $tabla = "inventario_cliente_". $_SESSION['id'];
    $stock = $_POST['cantidad'];
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $creado_el = $fecha . " a las ". $hora;  
    $estatus = "activo";
    $year = $_POST["año"];
    $marca = $_POST["marca"];
    $modelo =  $_POST["modelo"];
    $yonke_id = $_POST["yonke_id"]; //yonke id test
    //Validamos si se mandaron fotos o no
    //chown('Applications/XAMPP/xamppfiles/htdocs/Yonkemovil', 'www-data:www-data');

    if ($numero_fotos_subidas == 0) {
       
        //Verificamos si existe la carpeta unica de cliente
        if (!is_dir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id)) {
            mkdir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id,0777);
        }

        $query = "INSERT INTO $tabla(id, año, modelo, marca, stock, estatus, fecha, id_yonke) VALUES (null,?,?,?,?,?,?,?);";
        $resultado = $con->prepare($query);
        $resultado->bind_param('sssssss', $year, $modelo, $marca, $stock, $estatus, $fecha, $yonke_id);
        $resultado->execute();
        $resultado->close();
        $last_id = mysqli_insert_id($con);

            //Verificamos si existe la carpeta unica de cliente
            if (!is_dir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id . "/". $last_id. "_". $year . "_". $modelo . "_" .$marca)) {
                mkdir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id . "/". $last_id. "_". $year . "_". $modelo . "_" .$marca, 0777);
    
                
    
            }else{ //En este caso se encontro una carpeta con ese mismo modelo de carro y año
               // print_r("Ya agrego este modelo de auto a su base de datos");
            }

            print_r(1);
    }else{

        //Verificamos si existe la carpeta unica de cliente
        if (!is_dir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id)) {
            mkdir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id, 0777);
        }

     //Insertamos la unidad en el inventario de yonkes
        $query = "INSERT INTO $tabla(id, año, modelo, marca, stock, estatus, fecha, id_yonke) VALUES (null,?,?,?,?,?,?,?);";
        $resultado = $con->prepare($query);
        $resultado->bind_param('sssssss', $year, $modelo, $marca, $stock, $estatus, $fecha, $yonke_id);
        if($resultado->execute()){

            $last_id = mysqli_insert_id($con);
            //Verificamos si existe la carpeta unica de cliente
        if (!is_dir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id . "/". $last_id. "_". $year . "_". $modelo . "_" .$marca)) {
            mkdir('../../frontend/recursos/img/base_datos/carpeta_user_'. $_SESSION['id'] .'/yonke_id_' . $yonke_id . "/". $last_id . "_". $year . "_". $modelo . "_" .$marca, 0777);

        }else{ //En este caso se encontro una carpeta con ese mismo modelo de carro y año
           // print_r("Ya agrego este modelo de auto a su base de datos");
        }
            
        }else{
            print_r("No se ejectuto consulta idyonke: ".$id_yonke ." ******");
        };
        
        $resultado->close();

       
 
     $count = 0; //Creamos un contador para contar las subidas
     $data = (!file_exists('database.json') ? [] : json_decode( file_get_contents('database.json'))); //verificamos si existe nuestro JSON donde se almacenara la info de la update
 
     $writable = fopen('database.json', 'w'); //Lo creamos
 
 
     //Aqui recorremos la variable global FILES done verificamos si se movio el archivo a la carpeta unica del cliente
     foreach($_FILES as $key => $file){
 
         $file["name"] = $last_id . "_". $key;
         if (!move_uploaded_file($file['tmp_name'], '../../frontend/recursos/img/base_datos/carpeta_user_' . $_SESSION['id'] .'/yonke_id_'. $yonke_id .'/'. $last_id. "_". $year . "_". $modelo . "_" .$marca .'/'. $file['name'] . '.jpg')) {
             
             return print_r(json_encode(['message' => 'No fue posible subir el archivo ' . $file['name'], 'status' => http_response_code(500)]));
 
         }
 
         //Agregamos el id y el nombre del archivo img al arreglo $data
        /*  array_push($data, [
             'id'=>$key,
             'file_name' => $file['name']
         ]); */
 
         $count++; //Incrementamos el contador
 
 
     }

     print_r(1);
 
     //Vericiamos que el contador sea igual a la longitud de FILES
    /*  if( $count == count($_FILES)){
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
     } */

    }
 
    

    ?>