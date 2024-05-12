<?php
session_start();
$_SESSION['vista'] = "usuarios";
$config = include '../conexion.php';

if (isset($_POST['form-add-submit'])) {
  $last_element=null;
  try {
    $sentencia = $con->prepare("INSERT INTO users (name, last_name,dob,password,phone_number,email,active)
      VALUES (:fn,:ln,:dob,:pw,:pn,:em,:ac)");
    $sentencia->execute(array(
      ':fn' => $_POST['name'],
      ':ln' => $_POST['lastname'],
      ':dob' => $_POST['dob'],
      ':pw' => $_POST['password'],
      ':pn' => $_POST['phone'],
      ':em' => $_POST['email'],
      ':ac' => $_POST['active'] == '1' ? 1 : 0
    ));

    $last_element = $con->lastInsertId();
    $last_element = intval($last_element);

    // if(isset($_POST['Roles'])){
    //   $selected_roles = $_POST['Roles'];
    //     foreach($selected_roles as $role) {
    //       //getting the role id
    //       $stmt_roles = $con->prepare("SELECT id FROM roles WHERE role = :role");
    //       $stmt_roles->execute([':role' => $role]);
    //       $role_row = $stmt_roles->fetch(PDO::FETCH_ASSOC);
    //       $role_id = $role_row['id'];

    //       //inserting into users_roles
    //       $stmt_users = $con->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)");
    //       $stmt_users->execute([
    //         ':uid' => $last_element,
    //         ':rid' => $role_id
    //       ]);
    //     }
    // }
    $_SESSION['success']="Usuario creado exitosamente";
    $_SESSION['vista']="usuarios";
    header("Location: ../../index.php");
    return;
  } 
  catch(PDOException $error) {
    $_SESSION['error'] = $error->getMessage();
    $_SESSION['vista']="usuarios";
    header("Location: ../../index.php");
    return;
  }  
}
?>
