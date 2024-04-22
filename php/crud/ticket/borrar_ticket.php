<?php
$config = include '../../conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

try {    
  $id = $_GET['id'];
  $consultaSQL = "DELETE FROM tickets WHERE id =" . $id;

  $sentencia = $con->prepare($consultaSQL);
  $sentencia->execute();

  $_SESSION['vista'] = "tickets";
  header('Location: ../../../index.php');

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger" role="alert">
        <?= $resultado['mensaje'] ?>
      </div>
    </div>
  </div>
</div>