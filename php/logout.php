<?php
session_start();
session_destroy();
/**
 * Modify session table to set it as "inactive"*/
include 'conexion.php';

$inactive_query = $con->prepare("INSERT INTO session (username, is_active, last_activity) VALUES (:uname, :active, NOW())");
$inactive_query->execute([':active' => 0, ':uname' => $_SESSION['username']]);

print "<script>window.location='../home.php';</script>";
?>