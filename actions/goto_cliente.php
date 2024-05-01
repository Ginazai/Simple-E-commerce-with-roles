<?php
session_start();
$_SESSION['vista']="cliente";
header("location: ../index.php");
?>