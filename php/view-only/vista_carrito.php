<?php
define("N_RGT", 5);
$config = include 'php/conexion.php';

try {
  $username=$_SESSION['username'];
  $per_page_html = '';
  $page = 1;
  $start=0;

  if(!empty($_POST["page"])) {
    $page = $_POST["page"];
    $start=($page-1) * N_RGT;
  }
  $limit=" limit " . $start . "," . N_RGT;

  $consultaSQL = "SELECT orders.cantidad, orders.id_item, data_sales.titulo,
                  data_sales.descripcion, data_sales.precio, 
                  data_sales.id_compra FROM orders
                  RIGHT JOIN data_sales
                  ON data_sales.id_compra = orders.id_prod 
                  WHERE orders.username=:uname";
  $pagination_statement = $con->prepare($consultaSQL);
  $pagination_statement->execute([":uname"=>$username]);

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
  $pdo_statement->execute([":uname"=>$username]);

  $compras = $pdo_statement->fetchAll();

  if(!empty($_POST['facturacion'])){
    $_SESSION['vista']="compras";
  }

  $error = false;
} catch(PDOException $error) {
  $error = true;
  $error= $error->getMessage();
}

$titulo = 'Articulos en el carrito ';

//navbar url variable path
$index_url = "../../index.php";
$home_url = "../../home.php";
$customer_url = "vista_cliente.php";
$ticket_url = "ticket/crear_ticket.php";
$user_url = "../usuario/crear_usuario.php";
$category_url = "../categoria/crear_categoria.php";
$logout_url = "../logout.php";
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
      <table class="table">
        <thead>
          <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Precio</th>
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
                <td><?php echo $fila["titulo"]; ?></td>
                <td><?php echo $fila["descripcion"]; ?></td>
                <td><?php echo $fila["precio"]; ?></td>
                <td><?php echo $fila["cantidad"]; ?></td>
                <td><a href="<?= 'php/view-only/actions/remove_cart.php?id=' . $fila["id_item"] ?>">🗑️Borrar</a></td>
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
  <div class="form-group my-3">
    <form id="go-back" name="go-back" action="php/view-only/actions/goto_sales.php" type="post"></form>
    <form action="php/view-only/actions/facturacion.php" name="facturar" id="facturar" type="post"></form>
    <button form="facturar" type="submit" class="btn btn-dark">Facturar</button>
    <button form="go-back" class="btn btn-secondary" type="submit">Regresar al inicio</button>
  </div>
</div>