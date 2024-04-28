<?php
if(!empty($_POST)){
	if(isset($_POST["name"]) &&isset($_POST["last-name"]) &&isset($_POST["email"]) &&isset($_POST["password"]) &&isset($_POST["confirm_password"])){
		if($_POST["name"]!=""&& $_POST["last-name"]!=""&&$_POST["email"]!=""&&$_POST["password"]!=""&&$_POST["password"]==$_POST["confirm_password"]){
			
			include "conexion.php";

			$found=false;
			$sql1= $con->prepare("SELECT * FROM users WHERE email = :em");
			$sql1->execute([':em' => $_POST['email']]);
			while ($r=$sql1->fetch(PDO::FETCH_ASSOC)) {
				$found=true;
				break;
			}
			if($found){
				echo "<script>alert(\"Nombre de usuario o email ya estan registrados.\");window.location='../home.php';</script>";
			}		
			$sql = $con->prepare("INSERT INTO users(email,password,name,last_name,dob,phone_number,active) VALUES (:em,:pw,:nm,:ln,:dob,:pn,:a)");
			$sql->execute([
				':em' => $_POST['email'],
				':pw' => $_POST['password'],
				':nm' => $_POST['name'],
				':ln' => $_POST['last-name'],
				':dob' => $_POST['dob'],
				':pn' => $_POST['phone'],
				':a' => 1
			]);
			if($sql){
				echo "<script>alert(\"Registro exitoso. Proceda a logearse\");window.location='../home.php';</script>";
			}
		}
	}
}
?>