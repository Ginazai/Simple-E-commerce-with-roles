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
  $resultado['mensaje'] = 'El articulo no existe';
} else {
  $id = $_GET['id'];

  $sales = $con->prepare(
    "SELECT * FROM data_sales WHERE id_compra = :idc");
  $sales->execute([':idc' => $id]);

  $compras = $sales->fetchAll()[0];

  $username = $_SESSION['username'];
  $data_before = array(
    "username" => $username,
    "titulo" => $compras['titulo'],
    "descripcion" => $compras['descripcion'],
    "precio" => floatval($compras['precio']),
    "cantidad" => intval($compras['cantidad'])
  );
}

if (isset($_POST['submit'])) {
  try {
    $id = $_GET['id'];

    $data_after = array(
      "username" => $username,
      "titulo" => $_POST['titulo'],
      "descripcion" => $_POST['desc'],
      "precio" => floatval($_POST['precio']),
      "cantidad" => intval($_POST['cantidad'])
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

      $consulta = $con->prepare("UPDATE data_sales SET titulo = :title, descripcion = :description,
        precio = :price, fechacompra = NOW(), cantidad = :amount WHERE id_compra = :id");
      $consulta->execute(array(
        ':id' => $id,
        ':title' => $_POST['titulo'],
        ':description' => $_POST['desc'],
        ':price' => $_POST['precio'],
        ':amount' => $_POST['cantidad']
      ));

      $sales = $con->prepare(
        "SELECT * FROM data_sales WHERE id_compra = :idc");
      $sales->execute([':idc' => $id]);

      $compras = $sales->fetchAll()[0];
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
          El articulo <?= $compras['titulo'] ?> ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($compras) && $compras) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el articulo: <?= $compras['titulo'] ?></h2>
        <hr>
    <!--------------------------Add Form -------------------------->
        <form id='add' class='row g-3' role='form' method='post'>

          <div class='col-12 form-floating'>
              <input type='text' class='form-control' id='titulo' name='titulo' placeholder='Titulo' value="<?=$compras['titulo']?>">
              <label for='titulo'>Titulo</label>
          </div>

          <div class='col-12 form-floating'>
            <input type='text' class='form-control' id='desc' name='desc' placeholder='Descripcion' value="<?=$compras['descripcion']?>">
            <label for='desc'>Descripcion</label>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input id='precio' name='precio' type="number" class="form-control" step="0.01" min="0" aria-label="Amount (to the nearest dollar)" value="<?=$compras['precio']?>">
          </div>

          <div class='col-12 form-floating'>
            <input type='number' class='form-control' id='cantidad' name='cantidad' placeholder='Cantidad' value="<?=$compras['cantidad']?>">
            <label for='cantidad'>Cantidad</label>
          </div>
          <div class="form-group my-3">
            <input type="submit" name="submit" class="btn btn-dark" value="Actualizar">
            <a class="btn btn-secondary" href="../../../index.php">Regresar al inicio</a>
          </div>
        </form>
<!--------------------------Add Form -------------------------->
      </div>
    </div>
  </div>
  <?php
}
?>