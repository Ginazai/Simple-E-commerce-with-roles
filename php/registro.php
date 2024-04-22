<?php

if(!empty($_POST)){
	if(isset($_POST["username"]) &&isset($_POST["fullname"]) &&isset($_POST["email"]) &&isset($_POST["password"]) &&isset($_POST["confirm_password"])){
		if($_POST["username"]!=""&& $_POST["fullname"]!=""&&$_POST["email"]!=""&&$_POST["password"]!=""&&$_POST["password"]==$_POST["confirm_password"]){
			
			include "conexion.php";

			$default_role = 2;
			$found=false;
			$sql1= $con->prepare("SELECT * FROM user WHERE username = :uname or email = :em");
			$sql1->execute([':uname' => $_POST['username'], ':em' => $_POST['email']]);
			while ($r=$sql1->fetch(PDO::FETCH_ASSOC)) {
				$found=true;
				break;
			}
			if($found){
				print "<script>alert(\"Nombre de usuario o email ya estan registrados.\");window.location='../home.php';</script>";
			}		
			$sql = $con->prepare("INSERT INTO user(fullname, username, email,password,created_at) VALUES (:fname, :uname, :em, :pwd, :t)");
			$role_sql = $con->prepare("INSERT INTO user_roles(user_id, role_id) VALUES (:uid, :rid)");
			$sql->execute([
				':uname' => $_POST['username'],
				':fname' => $_POST['fullname'],
				':em' => $_POST['email'],
				':pwd' => $_POST['password'],
				':t' => date("Y-m-d H:i:s")
			]);
			$role_sql->execute([':uid' => $con->lastInsertId(), ':rid' => $default_role]);
			if($sql and $role_sql){
				print "<script>alert(\"Registro exitoso. Proceda a logearse\");window.location='../home.php';</script>";
			}
		}
	}
}



?>