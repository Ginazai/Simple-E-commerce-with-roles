<?php
session_start();
$config=require_once "actions/conexion.php";
$cliente_link="actions/goto_cliente.php";
if(isset($_SESSION['user_data'])){
	$data=$_SESSION['user_data']; 
	$roles=$data['roles'];
}

if(!isset($_POST['vista'])) {
	if(isset($_SESSION['vista'])){
		$vista = $_SESSION['vista'];
	} else {
		if(isset($_SESSION['user_data']['roles']['admin'])){
			$vista = "tickets";
		} elseif(isset($_SESSION['user_data']['roles']['inventory'])) {
			$vista = "compras";
		}
	}
} else {
	$vista=$_POST['vista'];}


//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$logo="html/assets/images/icons/icon.png";
$customer_url = "index.php";
$ticket_url = "actions/create/crear_ticket.php";
$user_url = "actions/create/crear_usuario.php";
$category_url = "actions/create/crear_categoria.php";
$compras_url = "views/vista_compra.php";
$logout_url = "actions/logout.php";
?>

	<?php 
	require_once "html/navbar.php";

	if(isset($data)){
		if(isset($data['roles']['admin']['write'])&&
			$data['roles']['admin']['write']){
			require_once "html/top_menu.php";
			if($vista == "tickets") {
			$_SESSION['render']=require_once "views/vista_ticket.php"; $_SESSION['vista'] = $vista;}
			elseif($vista == "usuarios") {
				$_SESSION['render']=require_once "views/vista_usuario.php"; $_SESSION['vista'] = $vista;}
			elseif($vista == "categorias") {
				$_SESSION['render']=require_once "views/vista_categoria.php"; $_SESSION['vista'] = $vista;} 
			if($vista == "compras"){
				$_SESSION['render']=require_once "views/vista_compra.php"; $_SESSION['vista'] = $vista;}
		} elseif(isset($data['roles']['inventory']['read'])&&
				$data['roles']['inventory']['read']&&
				!$data['roles']['inventory']['write']){
			if($vista == "compras"){
				require_once "html/top_menu_client.php";
				$_SESSION['render']=require_once "views/vista_cliente.php"; $_SESSION['vista'] = $vista;}
			elseif($vista=="carrito"){
				$_SESSION['render']=require_once "views/vista_carrito.php"; $_SESSION['vista'] = $vista;}
			elseif($vista=="factura"){
				$_SESSION['render']=require_once "views/vista_factura.php"; $_SESSION['vista'] = $vista;}
			elseif($vista=="historial"){
				$_SESSION['render']=require_once "views/vista_historial.php"; $_SESSION['vista'] = $vista;}
			else {
					$_SESSION['render']=require_once "views/vista_cliente.php"; $_SESSION['vista'] = $vista;}
		} elseif(isset($data['roles']['inventory']['write'])&&
				$data['roles']['inventory']['write']&&
				$data['roles']['inventory']['read']){
			require_once "html/top_menu.php";
			if($vista == "compras"){
				$_SESSION['render']=require_once "views/vista_compra.php"; $_SESSION['vista'] = $vista;}
		}
	} else{
		require_once "html/top_menu_client.php";
		if($vista=="cliente"){
			$_SESSION['render']=require_once "views/vista_cliente.php"; $_SESSION['vista'] = $vista;}
		elseif($vista=="carrito"){
				$_SESSION['render']=require_once "views/vista_carrito.php"; $_SESSION['vista'] = $vista;}
		elseif($vista=="factura"){
			$_SESSION['render']=require_once "views/vista_factura.php"; $_SESSION['vista'] = $vista;}
		elseif($vista=="historial"){
			$_SESSION['render']=require_once "views/vista_historial.php"; $_SESSION['vista'] = $vista;}
		else {$_SESSION['render']=require_once "views/vista_cliente.php"; $_SESSION['vista'] = $vista;}
	}

	?>
	</body>
</html>