<?php
define("N_RGT", 5);
$error = false;
$config = include 'actions/conexion.php';

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
    $consultaSQL = 'SELECT DISTINCT users.*, user_roles.*,
                    roles.* FROM users 
                    JOIN user_roles
                    ON users.user_id = user_roles.user_id
                    RIGHT JOIN roles 
                    ON user_roles.role_id = roles.role_id
                    WHERE users.name LIKE :keyword OR users.last_name 
                    LIKE :keyword OR users.email LIKE :keyword 
                    ORDER BY users.user_id DESC 
                    GROUP BY users.user_id';

    $pagination_statement = $con->prepare($consultaSQL);
    $pagination_statement->execute([':keyword' => $search_keyword]);
  } else {
    $consultaSQL = "SELECT DISTINCT users.*, user_roles.*,
                    roles.* FROM users 
                    JOIN user_roles
                    ON users.user_id = user_roles.user_id
                    JOIN roles 
                    ON user_roles.role_id = roles.role_id
                    GROUP BY users.user_id";

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

  // while($row=$pdo_statement->fetch(PDO::FETCH_ASSOC)){$json_data[]=$row;}
  // $output=json_encode($json_data, JSON_PRETTY_PRINT);
  // echo 
  // "<script type='text/javascript'>
  //   console.log($output);
  // </script>";

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
        <?php if(isset($_SESSION['user_data']['roles']['admin']['write'])&&
                      $_SESSION['user_data']['roles']['admin']['write']):?>
         <button class='btn btn-dark' type='submit' data-bs-toggle='modal' data-bs-target='#add-user'>+ Agregar</button>
        <?php endif; ?>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Correo electronico</th>
            <th>Contrase&ntilde;a</th>
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
                <td><?php echo $fila["user_id"]; ?></td>
                <td><?php echo $fila["name"] . " " . $fila["last_name"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["password"]; ?></td>
                <td>
                  <?php  
                  $query = $con->prepare("SELECT user_roles.*, roles.* 
                                          FROM user_roles 
                                          JOIN roles
                                          ON roles.role_id = user_roles.role_id
                                          WHERE user_roles.user_id = :uid");
                  $query->execute([":uid"=>$fila["user_id"]]); 
                  $data = $query->fetchAll();
                  foreach($data as $role){
                    echo $role['role'] . "<br>";
                  } 
                  ?>
                </td>
                <td>
                  <a href="<?= 'php/crud/usuario/borrar_usuario.php?id=' . $fila["user_id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/usuario/editar_usuario.php?id=' . $fila["user_id"] ?>">✏️Editar</a>
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
<?php if(isset($_SESSION['user_data']['roles']['admin']['write'])&&
              $_SESSION['user_data']['roles']['admin']['write']):?>
<!---------------------------------------------- Add modal ---------------------------------------------->
<div class='modal fade' id='add-user' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='modal-label'>Agregar usuario</h1>
      </div>
      <div class='modal-body'>
        <div class='container-fluid justify-content-center form-signin'>
    <!--------------------------Add Form -------------------------->
          <form id='user-add' class='row g-3' role='form' name='user-add' action='actions/create/crear_usuario.php' method='post'>

            <div class='row g-2'>
              <div class='form-floating'>
                <input type='text' name='fullname' id='name' class='form-control' placeholder='Nombre'>
                <label for='name'>Nombre</label>
              </div>
              <div class='form-floating'>
                <input type='text' name='username' id='username' class='form-control' placeholder='Apellido'>
                <label for='username'>Apellido</label>
              </div>
            </div>
            <div class='form-floating'>
              <input class='form-control' type='date' name='dob' id='dob' placeholder='Fecha de nacimiento'>
              <label for='dob'>Fecha de nacimiento</label>
            </div>

            <div class='form-group'>
              <label>Roles</label><br>

              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='Roles[admin]' value='admin'> Administrador
                </label>
              </div>

              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='Roles[customer]' value='customer'> Cliente
                </label>
              </div>

              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='Roles[supervisor]' value='supervisor'> Supervisor
                </label>
              </div>
              
              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='Roles[software_specialist]' value='software_specialist'> Especialista de software
                </label>
              </div>

              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='Roles[hardware_specialist]' value='hardware_specialist'> Especialista de hardware
                </label>
              </div>
            </div>

            <div class='form-floating'>
              <input type='password' name='password' id='password' class='form-control' placeholder='Contrase&ntilde;a'>
              <label for='password'>Contrase&ntilde;a</label>
            </div>
            <div class='input-group'>
              <span id='phone-label' class='input-group-text'>+507</span>
              <input type='number' name='phone' id='phone' class='form-control' placeholder='Numero de telefono' aria-describedby='phone-label'>
            </div>
            <div class='form-floating'>
              <input type='email' name='email' id='email' class='form-control' placeholder='Correo Electronico'>
              <label for='email'>Correo Electronico</label>
            </div>

            <div class='checkbox-inline'>
              <label>
                <input type='checkbox' name='' value=''> Active
              </label>
            </div>
            
          </form>
<!--------------------------Add Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <form>
          <button type='submit' form='user-add' class='btn btn-info'>Agregar</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--------------------------Add modal -------------------------->
<?php endif; ?>