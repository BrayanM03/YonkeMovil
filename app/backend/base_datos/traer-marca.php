<?php
    session_start();
    include '../login/conexion.php';
    $con= $conectando->conexion();

    if (!$con) {
        echo "maaaaal";
    }

    if (isset($_POST["searchTerm"])) {
        $term = $_POST["searchTerm"];
        $parametro = "%$term%";

       $validar_comp = $con->prepare("SELECT COUNT(*) total FROM marcas WHERE id LIKE ? OR nombre LIKE ? OR imagen LIKE ?");
       $validar_comp->bind_param('sss', $parametro, $parametro, $parametro);
       $validar_comp->execute();
       $validar_comp->bind_result($total_comp);
       $validar_comp->fetch();
       $validar_comp->close();



      if ($total_comp > 0) {

          $traerMarcas="SELECT * FROM marcas  WHERE nombre LIKE '%$term%'
                                                                  OR imagen LIKE '%$term%'
                                                                  OR id LIKE '%$term%'";
          $result = mysqli_query($con, $traerMarcas);
          while ($datas=mysqli_fetch_array($result)){

              $marcas_encontrados[]  = $datas;

          }
      }else{
        print_r("No se encontro nada");
      }


           echo json_encode($marcas_encontrados, JSON_UNESCAPED_UNICODE);
  }
    ?>
