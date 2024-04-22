<?php
define("N_RGT", 5);
$error = false;
$config = include 'php/conexion.php';

try {
  $search_keyword = '';
  $per_page_html = '';
  $page = 1;
  $start=0;

  if(!empty($_POST["page"])) {
    $page = $_POST["page"];
    $start=($page-1) * N_RGT;
  }
  $limit=" limit " . $start . "," . N_RGT;
  if (isset($_POST['usuarios'])) {
    $search_keyword = $_POST['usuarios'];
    $consultaSQL = 'SELECT * FROM user WHERE fullname LIKE :keyword OR username LIKE :keyword OR email LIKE :keyword ORDER BY id DESC ';

    $pagination_statement = $con->prepare($consultaSQL);
    $pagination_statement->execute([':keyword' => $search_keyword]);
  } else {
    $consultaSQL = "SELECT * FROM user";

    $pagination_statement = $con->prepare($consultaSQL);
    $pagination_statement->execute();
  }

  $row_count = $pagination_statement->rowCount();
  if(!empty($row_count)){
    $per_page_html .= "<div class='btn-group' role='group'>";
    $page_count=ceil($row_count/N_RGT);
    if($page_count>1) {
      for($i=1;$i<=$page_count;$i++){
        if($i==$page){
          $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn btn-dark" />';
        } else {
          $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn btn-dark" />';
        }
      }
    }
    $per_page_html .= "</div>";
  }
  
  $query = $consultaSQL.$limit;
  $pdo_statement = $con->prepare($query);
  isset($_POST['usuarios']) ? $pdo_statement->execute([':keyword' => $search_keyword]) : $pdo_statement->execute();
  $usuarios = $pdo_statement->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de usuarios (' . $_POST['apellido'] . ')' : 'Lista de usuarios ';
?>

<?php
if ($error) {

  echo("
    <div class='container mt-2'>
      <div class='row'>
        <div class='col-md-12'>
          <div class='alert alert-danger' role='alert'>
            $error 
          </div>
        </div>
      </div>
    </div>");

}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Nombre de Usuario</th>
            <th>Email</th>
            <th>Password</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($usuarios && $pdo_statement->rowCount() > 0) {
            //roles selection
            foreach ($usuarios as $fila) {
              //prevent user from editing himself
              //if($fila['id'] == $_SESSION['user_id']) {continue;}
              ?>
              <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["fullname"]; ?></td>
                <td><?php echo $fila["username"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["password"]; ?></td>
                <td>
                  <?php 
                  $user_id = $fila['id'];

                  $get_relation = $con->prepare("SELECT * FROM user_roles WHERE user_id = :uid");
                  $get_relation->execute([':uid' => $user_id]);
                  while($relation_row=$get_relation->fetch(PDO::FETCH_ASSOC)){
                    $role_id = $relation_row['role_id'];

                    $get_role_name = $con->prepare("SELECT role FROM roles WHERE id = :rid");
                    $get_role_name->execute([':rid' => $role_id]);
                    $role_names=$get_role_name->fetchAll();
                    foreach($role_names as $name){
                      echo($name['role'] . "<br>");
                    }
                  }
                  ?>
                </td>
                <td>
                  <a href="<?= 'php/crud/usuario/borrar_usuario.php?id=' . $fila["id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/usuario/editar_usuario.php?id=' . $fila["id"] ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
    <div class="row my-4 w-100 text-center">
      <form method="post">
        <?php echo $per_page_html; ?>
      </form>
    </div>
  </div>
</div>