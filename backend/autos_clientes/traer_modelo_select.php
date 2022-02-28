<?php
    session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión";
    }

    if (isset($_POST)) {
        $tabla_año = "modelos_" . $_POST["año"];
        $marca = $_POST["marca"];

       $validar_comp = $con->prepare("SELECT COUNT(*) total FROM $tabla_año WHERE marca =?");
       $validar_comp->bind_param("s", $marca);
       $validar_comp->execute();
       $validar_comp->bind_result($total_comp);
       $validar_comp->fetch();
       $validar_comp->close();



      if ($total_comp > 0) {

        
          $traerModelos="SELECT modelo FROM $tabla_año WHERE marca = '$marca'";

          $result = mysqli_query($con, $traerModelos);
          while($datas=mysqli_fetch_array($result)){

            $modelos_encontrados[]  = $datas;

          }
      


           echo json_encode($modelos_encontrados, JSON_UNESCAPED_UNICODE);
  }else{
    
        //print_r("No se encontraron resultados");
        $null = array();
        echo json_encode($null, JSON_UNESCAPED_UNICODE);

  }
}
    ?>
