<?php
session_start();
$config = include '../conexion.php';

try {    
  $id = $_GET['id'];

  $sentencia = $con->prepare("DELETE FROM users WHERE user_id=:id");
  $sentencia->execute([':id'=>$id]);

  $_SESSION['success']="El usuario ha sido eliminado";
  $_SESSION['vista']="usuarios";
  header("Location: ../../index.php");
  return;
} catch(PDOException $error) {
  $_SESSION['error']=$error->getMessage();
  $_SESSION['vista']="usuarios";
  header("Location: ../../index.php");
  return;
}
?>