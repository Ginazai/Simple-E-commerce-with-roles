<?php
session_start();
$_SESSION['vista'] = "categorias";
$config = include '../conexion.php';

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'la categoria ' . $_POST['categoria'] . ' ha sido agregada con éxito'
  ];

  try {
    $sentencia = $con->prepare("INSERT INTO categories ( category ) VALUES ( :ctg )");
    $sentencia->execute([':ctg' => $_POST['categoria']]);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>