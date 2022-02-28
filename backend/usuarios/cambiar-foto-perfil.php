<?php

session_start();
include '../login/conexion.php';
$con = $conectando->conexion();

if (!isset($_SESSION['id'])) {
    header("Location:../../login.php");
}

//Recibimos la data 64 de la imagen
$stringBase64 = $_POST["imgBase64"];

//Dividos el string y quitamos usando el separador coma
$explode = explode(',', $stringBase64);

//usamos la segunda parte despues la coma con toda la data base64 de la img
$decode = base64_decode($explode[1]);

//$img = imagecreatefromstring($decode);  No usaremos esto por el momento, es para transformar una img

if (!$decode) {
    die("La imagen base64 no es valida");
} else {

    //header('Content-Type:image/jpg');
    /* imagejpeg($img);
    imagedestroy($img); */ //Tampoco esto
    //Tomanos el identificador en este caso el nombre de usuario para eso hacemos una consulta en base al GET[id] 

    $id_usuario = $_POST["id_user"];
    $validar_comp = $con->prepare("SELECT usuario FROM usuarios WHERE id LIKE ?");
    $validar_comp->bind_param('s', $id_usuario);
    $validar_comp->execute();
    $validar_comp->bind_result($usernamepp);
    $validar_comp->fetch();
    $validar_comp->close();

    $ruta = "../../frontend/recursos/img/pp/". $usernamepp .".jpg";
    file_put_contents($ruta, $decode);
    print_r($usernamepp);

}
/* 
if (isset($_POST)) {
    
    //Decodificamos la img en base64
    $decode = base64_decode($_POST)
} */
