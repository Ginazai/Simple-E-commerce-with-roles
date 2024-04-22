<?php
$config = include '../../conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

try {
  $id = $_GET['id'];

  $sentencia = $con->prepare("DELETE FROM categorias WHERE id = :id");
  $sentencia->execute([':id' => $id]);

  $_SESSION['vista'] = "categorias";
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