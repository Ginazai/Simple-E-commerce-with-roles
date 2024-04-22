<?php
if(!empty($_POST)){
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		if($_POST["username"]!=""&&$_POST["password"]!=""){
			try {
				include "conexion.php";

				$u_name = $_POST['username'];
				$pwd = $_POST['password'];
			
				$user_id=null;
				$user_role=array();
				$query= $con->prepare("SELECT * FROM user WHERE email = :em and password = :pass or username = :un and password = :pass");
				$query->execute([':un' => $u_name, ':em' => $u_name, ':pass' => $pwd]);
				while ($r=$query->fetch(PDO::FETCH_ASSOC)) {
					$user_id=$r["id"];
					$user_name=$r["fullname"];
					$username=$r["username"];

					$sql2= $con->prepare("SELECT * FROM user_roles WHERE user_id= :uid");	
					$sql2->execute([':uid' => $user_id]);
						while ($r2=$sql2->fetch(PDO::FETCH_ASSOC)){
							array_push($user_role, $r2['role_id']);
						}
					break;
				}
				if($user_id==null){
					print "<script>alert(\"Acceso invalido.\");window.location='../home.php';</script>";
				} else{
					session_start();
					$_SESSION['Roles']=$user_role;
					$_SESSION['user_name']=$user_name;
					$_SESSION['username']=$username;
					$_SESSION['user_id']=$user_id;
					/**
					 * Session log table
					 * */
					$session_query = $con->prepare("INSERT INTO session (username, is_active, last_activity) 
						VALUES (:uname, :active, NOW())");
					$session_query->execute(array(
						':uname' => $username,
						':active' => 1
					));

					print "<script>window.location='../home.php';</script>";				
				}
			}
			catch (Exception $e) {
				$e->getMessage();
				echo($e->getMessage());
			}
		}
	}
}



?>