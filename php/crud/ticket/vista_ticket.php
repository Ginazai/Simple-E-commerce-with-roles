<?php
$error = false;
$config = include 'php/conexion.php';
$vista = "tickets";

try {
  if (isset($_POST['tickets'])) {
    $consultaSQL = "SELECT * FROM tickets WHERE ticket LIKE '%" . $_POST['tickets'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM tickets";
  }

  $sentencia = $con->prepare($consultaSQL);
  $sentencia->execute();

  $tickets = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['ticket']) ? 'Lista de tickets (' . $_POST['ticket'] . ')' : 'Lista de tickets';
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
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th># de ticket</th>
            <th>Consulta</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($tickets && $sentencia->rowCount() > 0) {
            foreach ($tickets as $fila) {
              ?>
              <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["nombre"]; ?></td>
                <td><?php echo $fila["apellido"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["ticket"]; ?></td>
                <td><?php echo $fila["consulta"]; ?></td>
                <td>
                  <a href="<?= 'php/crud/ticket/borrar_ticket.php?id=' . $fila["id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/ticket/editar_ticket.php?id=' . $fila["id"] ?>">✏️Editar</a>
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