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
  if (isset($_POST['compras'])) {
    $search_keyword = $_POST['compras'];
    $consultaSQL = 'SELECT * FROM inventory WHERE product LIKE :keyword OR description LIKE :keyword ORDER BY product_id DESC ';

    $pagination_statement = $con->prepare($consultaSQL);
    $pagination_statement->execute([':keyword' => $search_keyword]);
  } else {
    $consultaSQL = "SELECT * FROM inventory";

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
  isset($_POST['compras']) ? $pdo_statement->execute([':keyword' => $search_keyword]) : $pdo_statement->execute();
  $compras = $pdo_statement->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['compras']) ? 'Lista de compras (' . $_POST['compras'] . ')' : 'Lista de compras ';
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
      <?php
      if (isset($resultado)) {
        ?>
        <div class="container mt-3">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                <?= $resultado['mensaje'] ?>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
      <h2 class="mt-3"><?= $titulo ?></h2>
      <button class='btn btn-dark' type='submit' data-bs-toggle='modal' data-bs-target='#add-compra'>+ Agregar</button>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Fecha de compra</th>
            <th>Cantidad</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($compras && $pdo_statement->rowCount() > 0) {
            //roles selection
            foreach ($compras as $fila) {
              //prevent user from editing himself
              //if($fila['id'] == $_SESSION['user_id']) {continue;}
              ?>
              <tr>
                <td><?php echo $fila["id_compra"]; ?></td>
                <td><?php echo $fila["username"]; ?></td>
                <td><?php echo $fila["titulo"]; ?></td>
                <td><?php echo $fila["descripcion"]; ?></td>
                <td><?php echo $fila["precio"]; ?></td>
                <td><?php echo $fila["fechacompra"]; ?></td>
                <td><?php echo $fila["cantidad"]; ?></td>
                <td>
                  <a href="<?= 'php/crud/compra/borrar_compra.php?id=' . $fila["id_compra"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/compra/editar_compra.php?id=' . $fila["id_compra"] ?>">✏️Editar</a>
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
<!---------------------------------------------- Add modal ---------------------------------------------->
<div class='modal fade' id='add-compra' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='modal-label'>Agregar articulo</h1>
      </div>
      <div class='modal-body'>
        <div class='container-fluid justify-content-center form-signin'>
    <!--------------------------Add Form -------------------------->
          <form id='add' class='row g-3' role='form' name='registro' action='../actions/create/crear_compra.php' method='post'>

            <div class='col-12 form-floating'>
                <input type='text' class='form-control' id='titulo' name='titulo' placeholder='Titulo'>
                <label for='titulo'>Titulo</label>
            </div>

            <div class='col-12 form-floating'>
              <input type='text' class='form-control' id='desc' name='desc' placeholder='Descripcion'>
              <label for='desc'>Descripcion</label>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">$</span>
              <input id='precio' name='precio' type="number" class="form-control" step="0.01" min="0" aria-label="Amount (to the nearest dollar)">
            </div>

            <div class='col-12 form-floating'>
              <input type='number' class='form-control' id='cantidad' name='cantidad' placeholder='Cantidad'>
              <label for='cantidad'>Cantidad</label>
            </div>

            <div class="input-group mb-3">
              <input type="file" class="form-control" name="upload-image" id="upload-image">
              <label class="input-group-text" for="image">Imagen</label>
            </div>
            
          </form>
<!--------------------------Add Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <form>
          <button type='submit' form='add' class='btn btn-info'>Agregar</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--------------------------Add modal -------------------------->