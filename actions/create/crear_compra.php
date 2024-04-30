<?php
session_start();

$config = include '../conexion.php';
$last_element=null;
try {
  $sentencia = $con->prepare("INSERT INTO inventory (image,product,description,price,amount)
    VALUES (:img, :product, :description, :price, :amount)");

  $image=$_FILES['upload-image']['tmp_name'];
  $image_data=file_get_contents($image);
  $base64_image=base64_encode($image_data);
  $sentencia->execute(array(
    ':img' => $base64_image,
    ':product' => $_POST['titulo'],
    ':description' => $_POST['desc'],
    ':price' => $_POST['precio'],
    ':amount' => $_POST['cantidad']
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