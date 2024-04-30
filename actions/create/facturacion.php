<?php
session_start();
include "../../conexion.php";

date_default_timezone_set("America/Panama");
$username = $_SESSION['username'];
$date = date("Y-m-d");  
$sale_id = $date . "-" . $username;

$get_buy = $con->prepare("SELECT orders.id_prod, orders.cantidad,
						data_sales.precio FROM orders RIGHT join data_sales 
						on orders.id_prod = data_sales.id_compra
						WHERE orders.username=:uname");
$get_buy->execute([":uname"=>$username]);
$data = $get_buy->fetchAll();
$subtotal=0;

if($data) {
	foreach($data as $item){
		$price=$item['precio'];
		$amount=$item['cantidad'];

		$total=$price*$amount;

		$subtotal += $total;
	}
	$save_receipt = $con->prepare("INSERT INTO receipt(monto,username,fechacompra) VALUES(:total, :uname, NOW())");
	$save_receipt->execute([
		":total" => $subtotal,
		":uname" => $username	
	]);
	$id_receipt=$con->lastInsertId();
	$id_receipt=intval($id_receipt);

	foreach($data as $item){
		$product=$item['id_prod'];
		$price=$item['precio'];
		$amount=$item['cantidad'];

		$save_list=$con->prepare("INSERT INTO receipt_list VALUES(:idlist,:idprod,:precio,:cantidad,:username)");
		$save_list->execute([
			":idlist" => $id_receipt,
			":idprod" => $product,
			":precio" => $price,
			":cantidad" => $amount,
			":username" => $username 
		]);
	}
	$_SESSION['last_receipt']=$id_receipt;

	$clear_order=$con->prepare("DELETE FROM orders WHERE username=:uname");
	$clear_order->execute([":uname"=>$username]);

	$_SESSION['vista']="factura";
	echo("<script type='application/javascript'>window.location='../../../index.php'</script>");
} else {
	echo("<script type='application/javascript'>window.location='../../../index.php'</script>");
}
?>