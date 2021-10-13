<?php
  include("bd.php");
  $buscado='';
  $tipo='';
    if (isset($_POST['buscado'])) {
      $buscado = $_POST['buscado'];
    }
    if (isset($_POST['tipo'])) {
      $tipo = $_POST['tipo'];
    }

  $coincidencias= array();

  $coincidencias= busqueda($buscado, $tipo);
  header('Content-Type: application/json');
  echo json_encode($coincidencias);
?>