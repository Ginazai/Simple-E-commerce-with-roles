<?php
session_start();
$_SESSION['vista']="carrito";
header("location: ../../../index.php");
?>