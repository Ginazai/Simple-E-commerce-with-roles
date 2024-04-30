<?php 
include '../../conexion.php';

$id=$_GET['id'];

$get_cantidad=$con->prepare("SELECT * FROM orders WHERE id_item=:id");
$get_cantidad->execute([":id"=>$id]);
$fila= $get_cantidad->fetchAll()[0];
$cantidad = $fila['cantidad'];
$item_id=$fila['id_prod'];

$re_insert=$con->prepare("SELECT cantidad FROM data_sales WHERE id_compra=:ai");
$re_insert->execute([":ai"=>$item_id]);
$amount=$re_insert->fetchAll()[0];
$amount=$amount['cantidad'];

$new_amount=$amount+$cantidad;

$update_amount=$con->prepare("UPDATE data_sales SET cantidad=:c WHERE id_compra=:icom");
$update_amount->execute([":icom"=> $item_id, ":c"=>$new_amount]);

$remove_item=$con->prepare("DELETE FROM orders WHERE id_item=:id");
$remove_item->execute([":id"=>$id]);
echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
?>
