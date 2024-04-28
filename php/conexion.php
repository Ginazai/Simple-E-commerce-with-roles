<?php
$host="localhost";
$user="";
$password="";
$db="e_commerce_admin_module";

$dsn = "mysql:host=$host;dbname=$db";
$con = new PDO($dsn, $user, $password);

?>