<?php
session_start();

$config = include '../../conexion.php';
$last_element=null;
try {
  $sentencia = $con->prepare("INSERT INTO data_sales (titulo, descripcion, precio, username, fechacompra, cantidad)
    VALUES (:titulo, :descripcion, :precio, :username, NOW(), :cantidad)");
  $sentencia->execute(array(
    ':titulo' => $_POST['titulo'],
    ':descripcion' => $_POST['desc'],
    ':precio' => $_POST['precio'],
    ':username' => $_SESSION['username'],
    ':cantidad' => $_POST['cantidad']
  ));

  $resultado = ['error' => false, 'mensaje' => 'El articulo ' . $_POST['titulo'] . ' ha sido agregado con éxito'];
  $_SESSION['vista']="compras";
  header('Location: ../../../index.php');
} 
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
  $_SESSION['vista']="compras";
  header('Location: ../../../index.php');
}  
?>