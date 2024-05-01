<?php
session_start();
if(isset($_SESSION['user_data']['roles']['inventory']['write'])&&
		$_SESSION['user_data']['roles']['inventory']['write']){
	$_SESSION['vista']="compras";
} else {$_SESSION['vista']="cliente";}
header("location: ../index.php");
?>