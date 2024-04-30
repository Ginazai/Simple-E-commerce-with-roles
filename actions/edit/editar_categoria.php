<?php
session_start();
$config = include '../../conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'La categoria no existe';
}

if (isset($_POST['submit'])) {
  try {
    
    $consultaSQL = "UPDATE categorias SET
        categoria = :categoria
        WHERE id = :id";
    $consulta = $con->prepare($consultaSQL);
    $consulta->execute([
      "id"        => $_GET['id'],
      "categoria"    => $_POST['categoria']
    ]);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM categorias WHERE id = :id";

  $sentencia = $con->prepare($consultaSQL);
  $sentencia->execute([':id' => $id]);

  $categoria = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$categoria) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado la categoria';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$customer_url = "../view-only/vista_cliente.php";
$ticket_url = "../ticket/crear_ticket.php";
$user_url = "../usuario/crear_usuario.php";
$category_url = "crear_categoria.php";
$logout_url = "../../logout.php";
?>

<?php include '../../../html/navbar.php'; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          La categoria ha sido actualizada correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($categoria) && $categoria) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando la categoria: <p class="text-success"><?= $categoria['categoria']  ?></p></h2>
        <hr>
        <form method="post">
          <div class="form-floating">
            <input class="form-control" type="text" name="categoria" placeholder="Ingrese el nuevo nombre de: <?= $categoria['categoria']  ?>" id="categoria">
            <label for="categoria">Ingrese el nuevo nombre de: <?= $categoria['categoria']  ?></label>
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