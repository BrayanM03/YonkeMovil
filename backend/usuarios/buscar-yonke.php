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

       $validar_comp = $con->prepare("SELECT COUNT(*) total FROM yonkes WHERE id LIKE ? OR nombre LIKE ? OR contacto LIKE ? OR numero LIKE ? OR direccion LIKE ? OR rol LIKE ?");
       $validar_comp->bind_param('ssssss', $parametro, $parametro, $parametro, $parametro, $parametro, $parametro);
       $validar_comp->execute();
       $validar_comp->bind_result($total_comp);
       $validar_comp->fetch();
       $validar_comp->close();



      if ($total_comp > 0) {

          $traerYonkes="SELECT * FROM yonkes WHERE nombre LIKE '%$term%'
                                                        OR contacto LIKE '%$term%'
                                                        OR numero LIKE '%$term%'
                                                        OR direccion LIKE '%$term%'
                                                        OR rol LIKE '%$term%'";
          $result = mysqli_query($con, $traerYonkes);
          while ($datas=mysqli_fetch_array($result)){

              $yonkes_encontrados[]  = $datas;

          }
      }else{
        print_r("No se encontro nada");
      }


           echo json_encode($yonkes_encontrados, JSON_UNESCAPED_UNICODE);
  }
    ?>
