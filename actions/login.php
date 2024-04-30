<?php
if(!empty($_POST)){
	if(isset($_POST["email"]) &&isset($_POST["password"])){
		if($_POST["email"]!=""&&$_POST["password"]!=""){
			try {
				include "conexion.php";

				$u_name = $_POST['email'];
				$pwd = $_POST['password'];
			
				$user_role=array();
				$query= $con->prepare("SELECT users.*, roles.*, permissions.*
										FROM users 
										INNER JOIN user_roles
										ON users.user_id = user_roles.user_id
										INNER JOIN roles
										ON user_roles.role_id = roles.role_id
										INNER JOIN permissions 
										ON user_roles.permission_id = permissions.permission_id
										WHERE users.email = :em and users.password = :pass");
				$query->execute([':em' => $u_name, ':pass' => $pwd]);
				$data = $query->fetchAll();

				$roles = array();
				$i=0;
				foreach($data as $row){
					$permission=array(
						"read" => $row['_read'] == 1 ? true : false,
						"write" => $row['_write'] == 1 ? true : false
					);
					$roles[$row['role']] = $permission;
					if($i == (count($data)-1)){
						$user_data = array(
							"user_id" => $row['user_id'],
							"name" => $row['name'],
							"last_name" => $row['last_name'],
							"email" => $row['email'],
							"dob" => $row['dob'],
							"phone number" => $row['phone_number'],
							"active" => $row['active'],
							"roles" => $roles,
						); 
						break;
					}
					$i+=1;
				}

				if(!isset($user_data['user_id'])){
					echo "<script>alert(\"Acceso invalido.\");window.location='../home.php';</script>";
				} else{
					session_start();
					$_SESSION['user_data']=$user_data;
					/**
					 * Session log table
					 * */
					$session_query = $con->prepare("INSERT INTO data_session (user_id,activity,_time) 
						VALUES (:uid, :active, NOW())");
					$session_query->execute(array(
						':uid' => $_SESSION['user_data']['user_id'],
						':active' => 1
					));

					echo "<script>window.location='../home.php';</script>";				
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