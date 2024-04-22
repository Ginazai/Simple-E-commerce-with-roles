<?php
define("N_RGT", 2);
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
  if (isset($_POST['compras'])) {
    $search_keyword = $_POST['compras'];
    $consultaSQL = 'SELECT * FROM data_sales WHERE titulo LIKE :keyword OR descripcion LIKE :keyword ORDER BY id_compra DESC ';

    $pagination_statement = $con->prepare($consultaSQL);
    $pagination_statement->execute([':keyword' => $search_keyword]);
  } else {
    $consultaSQL = "SELECT * FROM data_sales";

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
  $error = false;
} catch(PDOException $error) {
  $error = true;
  $error= $error->getMessage();
}

$titulo = isset($_POST['compras']) ? 'Lista de articulos (' . $_POST['compras'] . '):' : 'Lista de articulos:';
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
      <div class="row">
        <form class="my-1" id="vista" name="vista" type="post" action="php/view-only/actions/goto_cart.php">
          <button type="submit" class="btn btn-dark my-0">Carrito</button>
        </form>
        <form class="my-1" id="vista" name="vista" type="post" action="php/view-only/actions/goto_history.php">
          <button type="submit" class="btn btn-dark my-0">Historial</button>
        </form>
      </div>
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Fecha de compra</th>
            <th>A&ntilde;adir al carrito</th>
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
                <td><?php echo $fila["fechacompra"]; ?></td>
                <td>
                  <form id="cantidad" name="cantidad" method="post" action="php/view-only/actions/add_sales.php?id=<?= $fila['id_compra'] ?>">
                  <?php 
                  echo("<select name='amount' class='form-select my-2'>");
                  $disponible = $fila["cantidad"];
                  for($i=0;$i<$disponible;$i++){
                    $i_plus = $i + 1;
                    if($i==0){echo("<option value='$i_plus' selected>$i_plus</option>");}
                    else{echo("<option value='$i_plus'>$i_plus</option>");}
                  } 
                  echo("</select>");
                  ?>
                    <button class="btn btn-md btn-dark" type="submit">+ a&ntilde;adir al carrito</button>                  
                  </form>
                </td>
                <td>                  
                                    
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