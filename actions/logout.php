<?php
session_start();
session_destroy();
/**
 * Modify session table to set it as "inactive"*/
include 'conexion.php';

$inactive_query = $con->prepare("INSERT INTO data_session (user_id, activity, _time) VALUES (:uid, :active, NOW())");
$inactive_query->execute([':uid' => $_SESSION['user_data']['user_id'], ':active' => 0]);

print "<script>window.location='../home.php';</script>";
?>