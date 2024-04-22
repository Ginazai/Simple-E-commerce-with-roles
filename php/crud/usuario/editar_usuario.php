<?php
session_start();
$config = include '../../conexion.php';

$resultado = [
  'error' => false,
  'advertencia' => false,
  'mensaje' => ''
];

$last_data = null;
if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El usuario no existe';
} else {
  $id = $_GET['id'];
  $role_names = array();
  $users_roles = $con->prepare(
    "SELECT * FROM user
    INNER JOIN user_roles ON user.id = user_roles.user_id
    INNER JOIN roles ON roles.id = user_roles.role_id
    WHERE user.id = :id");
  $users_roles->execute([':id' => $id]);
  $usuarios = $users_roles->fetchAll();
  $usuario = $usuarios[0];
  foreach($usuarios as $user){
    array_push($role_names, $user['role']);
  }

  $username = $_SESSION['username'];
  $data_before = array(
    "fullname" => $usuario['fullname'],
    "username" => $usuario['username'],
    "roles" => $role_names,
    "email" => $usuario['email'],
    "password" => $usuario['password']
  );
}

if (isset($_POST['submit'])) {
  try {
    $id = $_GET['id'];
    $roles = $_POST['Roles'];
    $role_names = array();
    foreach($roles as $role){
      array_push($role_names, $role);
    }

    $data_after = array(
      "fullname" => $_POST['fullname'],
      "username" => $_POST['username'],
      "roles" => $role_names,
      "email" => $_POST['email'],
      "password" => $_POST['password']
    );
    /**
     * Verify if an update was made
     * */
    $change = false;
    for($x=0;$x<count($data_after);$x++){
      $before_keys = array_keys($data_before);
      $after_keys = array_keys($data_after);
      if($data_before[$before_keys[$x]] != $data_after[$after_keys[$x]]){
        $change = true;
      } else {
        $resultado['advertencia'] = true;
        $resultado['mensaje'] = "No se ha realizado ningun cambio";
      }
    }

    if($change){
      $resultado['advertencia'] = false;
      $resultado['mensaje'] = "";

      $consulta = $con->prepare("UPDATE user SET fullname = :fn, username = :un,
        email = :em, password = :pw WHERE id = :id");
      $consulta->execute(array(
        ':id' => $_GET['id'],
        ':fn' => $_POST['fullname'],
        ':un' => $_POST['username'],
        ':em' => $_POST['email'],
        ':pw' => $_POST['password']
      ));
      /**
       * UPDATE user INNER JOIN roles on roles.user_id = user.id
       * 
       * */
      $update_role_query1 = $con->prepare("DELETE FROM user_roles WHERE user_id = :uid");
      $update_role_query1->execute(array(':uid' => $_GET['id']));

      foreach($role_names as $role){
        $select_role = $con->prepare("SELECT id FROM roles WHERE role = :role");
        $select_role->execute([":role" => $role]);
        $selected_row = $select_role->fetch(PDO::FETCH_ASSOC);
        $selected_id = $selected_row['id'];

        $reinsert_role_query = $con->prepare("INSERT INTO user_roles (user_id, role_id)
          VALUES (:uid, :rid)");
        $reinsert_role_query->execute([
          ":uid" => $_GET['id'],
          "rid" => $selected_id
        ]);
      }
      /**
       * Check data after every update
       * */
      $role_names = array();
      $data_change = $con->prepare("
        SELECT * FROM user
        INNER JOIN user_roles ON user_roles.user_id = user.id
        INNER JOIN roles ON user_roles.role_id = roles.id
        WHERE user.id = :uid");
      $data_change->execute([':uid' => $id]);
      $usuarios = $data_change->fetchAll();
      $usuario = $usuarios[0];
      foreach($usuarios as $user){
        array_push($role_names, $user['role']);
      }

      $data_update = $con->prepare("
        INSERT INTO data_trace ( username, _before, _after, _date ) 
        VALUES ( :uname, :bf, :af, NOW() )");
      $data_update->execute([
        ':uname' => $_SESSION['username'],
        ':bf' => json_encode($data_before),
        ':af' =>  json_encode($data_after)
      ]);
    }

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$ticket_url = "../ticket/crear_ticket.php";
$user_url = "crear_usuario.php";
$category_url = "../categoria/crear_categoria.php";
$logout_url = "../../logout.php";
?>

<?php include '../../../html/navbar.php'; ?>

<?php
if ($resultado['error']) {
  $mensaje = $resultado['mensaje'];
  echo("
    <div class='container mt-2'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='alert alert-danger' role='alert'>
          $mensaje
        </div>
      </div>
    </div>
  </div>");
} elseif($resultado['advertencia']) {
  $mensaje = $resultado['mensaje'];
  echo("
    <div class='container mt-2'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='alert alert-warning' role='alert'>
          $mensaje
        </div>
      </div>
    </div>
  </div>");
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error'] && !$resultado['advertencia']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El usuario <?= $usuario['fullname'] ?> ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el usuario <?= $usuario['fullname'] ?></h2>
        <hr>
        <form method="post">
          <div class="form-floating my-3">
            <input type="text" name="fullname" id="fullname" placeholder="Nombre completo" value="<?= $usuario['fullname'] ?>" class="form-control">
            <label for="fullname">Nombre completo</label>
          </div>
          <div class="form-floating my-3">
            <input type="text" name="username" id="username" placeholder="Nombre de usuario" value="<?= $usuario['username'] ?>" class="form-control" readonly="readonly">
            <label for="username">Nombre de usuario</label>
          </div>

          <div class="form-group my-3">
            <label>Roles</label><br>
            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[admin]" value="admin" <?= in_array("admin", $role_names) ? "checked" : "" ?>> Administrador
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[admin_compra]" value="admin_compra" <?= in_array("admin_compra", $role_names) ? "checked" : "" ?>> Administrador de Compras
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[customer]" value="customer" <?= in_array("customer", $role_names) ? "checked" : "" ?>> Cliente
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[supervisor]" value="supervisor" <?= in_array("supervisor", $role_names) ? "checked" : "" ?>> Supervisor
              </label>
            </div>
            
            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[software_specialist]" value="software_specialist" <?= in_array("software_specialist", $role_names) ? "checked" : "" ?>> Especialista de software
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[hardware_specialist]" value="hardware_specialist" <?= in_array("hardware_specialist", $role_names) ? "checked" : "" ?>> Especialista de hardware
              </label>
            </div>
          </div>

            <div class="form-floating my-3">
              <input type="email" name="email" id="email" placeholder="Email" value="<?= $usuario['email'] ?>" class="form-control" >
              <label for="email">Email</label>
            </div>

            <div class="form-floating my-3">
              <input type="text" name="password" id="password" placeholder="Password" value="<?= $usuario['password'] ?>" class="form-control">
              <label for="password">Password</label>
            </div>

            <div class="form-group my-3">
              <input type="submit" name="submit" class="btn btn-dark" value="Actualizar">
              <a class="btn btn-secondary" href="../../../index.php">Regresar al inicio</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
?>