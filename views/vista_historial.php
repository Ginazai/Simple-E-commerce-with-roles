<?php
$error = false;
$config = include 'actions/conexion.php';

try {
  date_default_timezone_set("America/Panama");
  $username=$_SESSION['username'];
  $user_name=$_SESSION['user_name'];
  $date=date("d-m-y");
  $date_2 = date("Y-m-d");  
  $sale_id = $date_2 . "-" . $username;
  
  $sentencia = $con->prepare("SELECT id, fechacompra FROM receipt WHERE username=:uname");
  $sentencia->execute([":uname"=>$username]);

  $detalles = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = 'Historial de pedidos:';
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
      <?php
      foreach($detalles as $resultado){
        $id=$resultado['id'];
        $fecha=$resultado['fechacompra'];
      ?>
      <div class="accordion my-3" id="accordion-data-<?= $resultado['id'] ?>">
        <div class="accordion-item">
          <h2 class="accordion-header w-100">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?=$resultado['id']?>" aria-expanded="false" aria-controls="collapseTwo">
              <?= $fecha ?>
            </button>
          </h2>
          <div id="collapse-<?=$resultado['id']?>" class="accordion-collapse collapse" data-bs-parent="#accordion-data-<?= $resultado['id'] ?>">
            <div class="accordion-body">
              <?php
              $get_data=$con->prepare("SELECT receipt_list.id_prod,
              receipt_list.cantidad, data_sales.titulo,
              receipt_list.precio, receipt_list.id_receipt
              FROM receipt_list INNER JOIN data_sales
              ON receipt_list.id_prod = data_sales.id_compra
              WHERE receipt_list.username=:uname");
              $get_data->execute(["uname"=>$username]);
              ?>
              <table class="table table-striped" style="background: url('<?= $logo ?>') center cover no-repeat;">
                <thead>
                  <tr>
                    <th>Articulo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $subtotal=0.00;
              while($row=$get_data->fetch(PDO::FETCH_ASSOC)){
                if($row['id_receipt']==$id){
                  $total=$row["precio"]*$row['cantidad'];
                ?>
                <tr>
                  <td><?php echo $row["titulo"]; ?></td>
                  <td><?php echo $row["cantidad"]; ?></td>
                  <td><?php echo $row["precio"]; ?></td>
                  <td><?php echo $total; ?></td>
                </tr>
                <?php
                $subtotal+=$total;
                }
              }
              $itbms=$subtotal*0.07;
              ?>
                <tr>
                  <td><b>Total:</b></td>
                  <td></td>
                  <td></td>
                  <td><b><?= round($subtotal, 2); ?></b></td>
                </tr>
                <tr>
                  <td><b>ITBMS:</b></td>
                  <td></td>
                  <td></td>
                  <td><b><?= round($itbms, 2); ?></b></td>
                </tr>
                <tr>
                  <td><b>Sub-total:</b></td>
                  <td></td>
                  <td></td>
                  <td><b><?= round($subtotal+$itbms, 2); ?></b></td>
                </tr>
              <tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>
  </div>
  <div class="row">
    <div class="form-group my-3">
      <form id="go-back" name="go-back" action="php/view-only/actions/goto_sales.php" type="post"></form>
      <button form="go-back" class="btn btn-secondary" type="submit">Regresar al inicio</button>
    </div>
  </div>
</div>