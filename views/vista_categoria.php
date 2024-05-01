<?php
$error = false;
$config = include 'actions/conexion.php';

try {

  if (isset($_POST['categorias'])) {
    $consultaSQL = "SELECT * FROM categories WHERE category LIKE '%" . $_POST['categorias'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM categories";
  }

  $sentencia = $con->prepare($consultaSQL);
  $sentencia->execute();

  $categoria = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['categoria']) ? 'Lista de tickets (' . $_POST['categoria'] . ')' : 'Lista de categorias ';
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
         <button class='btn btn-dark' type='submit' data-bs-toggle='modal' data-bs-target='#add-category'>+ Agregar</button>
        <?php endif; ?>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($categoria && $sentencia->rowCount() > 0) {
            foreach ($categoria as $fila) {
              ?>
              <tr>
                <td><?php echo $fila["category_id"]; ?></td>
                <td><?php echo $fila["category"]; ?></td>
                <td>
                  <a href="<?= 'actions/delete/borrar_categoria.php?id=' . $fila["category_id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'actions/edit/editar_categoria.php?id=' . $fila["category_id"] ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>
<?php if(isset($_SESSION['user_data']['roles']['admin']['write'])&&
              $_SESSION['user_data']['roles']['admin']['write']):?>
<!---------------------------------------------- Add modal ---------------------------------------------->
<div class='modal fade' id='add-category' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='modal-label'>Agregar usuario</h1>
      </div>
      <div class='modal-body'>
        <div class='container-fluid justify-content-center form-signin'>
    <!--------------------------Add Form -------------------------->
          <form id='category-add' class='row g-3' role='form' name='category-add' action='../actions/create/crear_categoria.php' method='post'>

            <div class='form-group'>
              <label for='categoria'>Ingrese una categoria</label>
              <input class='form-control' type='text' name='categoria'></input>
            </div>
    
          </form>
<!--------------------------Add Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <form>
          <button type='submit' form='category-add' class='btn btn-info'>Agregar</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--------------------------Add modal -------------------------->
<?php endif; ?>