<?php
    session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "No hay conexión";
    }

    if (isset($_POST)) {
        $tabla_año = "modelos_" . $_POST["año"];
       

       $validar_comp = $con->prepare("SELECT COUNT(*) total FROM $tabla_año");
       $validar_comp->execute();
       $validar_comp->bind_result($total_comp);
       $validar_comp->fetch();
       $validar_comp->close();



      if ($total_comp > 0) {

        
          $traerMarcas="SELECT DISTINCT marca FROM $tabla_año";

          $result = mysqli_query($con, $traerMarcas);
          while ($datas=mysqli_fetch_array($result)){

            $marcas_encontradas[]  = $datas;

          }
      


           echo json_encode($marcas_encontradas, JSON_UNESCAPED_UNICODE);
  }else{
    
        //print_r("No se encontraron resultados");
        $null = array();
        echo json_encode($null, JSON_UNESCAPED_UNICODE);

  }
}
    ?>
