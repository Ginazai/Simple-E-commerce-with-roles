<?php
session_start();
$config = include '../../conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El ticket no existe';
}

if (isset($_POST['submit'])) {
  try {

    $consulta = $con->prepare("UPDATE tickets SET
        nombre = :nombre,
        apellido = :apellido,
        email = :email,
        consulta = :consulta,
        created_at = created_at,
        updated_at = NOW()
        WHERE id = :id");
    $consulta->execute([
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "apellido"  => $_POST['apellido'],
      "email"     => $_POST['email'],
      "consulta" => $_POST['consulta']
    ]);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {    
  $id = $_GET['id'];

  $sentencia = $con->prepare("SELECT * FROM tickets WHERE id = :id");
  $sentencia->execute([':id' => $id]);

  $ticket = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$ticket) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el ticket';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$ticket_url = "crear_ticket.php";
$user_url = "../usuario/crear_usuario.php";
$category_url = "../categoria/crear_categoria.php";
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
          El ticket ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($ticket) && $ticket) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el ticket <?= $ticket['ticket'] ?></h2>
        <hr>
        <form method="post">
          <div class="form-floating my-3">
            <input class="form-control" type="text" name="nombre" placeholder="Nombre" id="nombre" value="<?= $ticket['nombre'] ?>">
            <label for="nombre">Nombre</label>
          </div>
          <div class="form-floating my-3">
            <input type="text" name="apellido" placeholder="Apellido" id="apellido" value="<?= $ticket['apellido'] ?>" class="form-control">
             <label for="apellido">Apellido</label>
          </div>
          <div class="form-floating my-3">
            <input type="email" name="email" placeholder="Email" id="email" value="<?= $ticket['email'] ?>" class="form-control">
            <label for="email">Email</label>
          </div>
          <div class="form-floating my-3">
            <input type="text" name="consulta" placeholder="Consulta" id="consulta" value="<?= $ticket['consulta'] ?>" class="form-control">
            <label for="edad">Consulta</label>
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

<?php //require "templates/footer.php"; ?>