<?php
session_start();
$_SESSION['vista'] = "usuarios";
$config = include '../conexion.php';

if (isset($_POST['submit'])) {
  $last_element=null;
  try {
    $sentencia = $con->prepare("INSERT INTO user (fullname, username, email, password, created_at)
      VALUES (:fn, :un, :em, :pw, NOW())");
    $sentencia->execute(array(
      ':fn' => $_POST['fullname'],
      ':un' => $_POST['username'],
      ':em' => $_POST['email'],
      ':pw' => $_POST['password']
    ));

    $last_element = $con->lastInsertId();
    $last_element = intval($last_element);

    if(isset($_POST['Roles'])){
      $selected_roles = $_POST['Roles'];
        foreach($selected_roles as $role) {
          //getting the role id
          $stmt_roles = $con->prepare("SELECT id FROM roles WHERE role = :role");
          $stmt_roles->execute([':role' => $role]);
          $role_row = $stmt_roles->fetch(PDO::FETCH_ASSOC);
          $role_id = $role_row['id'];
          //echo(var_dump($role_id));
          //echo(var_dump($last_element));

          //inserting into users_roles
          $stmt_users = $con->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)");
          $stmt_users->execute([
            ':uid' => $last_element,
            ':rid' => $role_id
          ]);
        }
    }
    $resultado = ['error' => false, 'mensaje' => 'El usuario ' . $_POST['fullname'] . ' ha sido agregado con éxito'];
  } 
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }  
}
?>
