<?php
session_start();
$_SESSION['vista']="compras";
header("location: ../../../index.php");
?>