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
		if(isset($_SESSION['user_data']['roles']['admin']['write'])){
			$vista = "tickets";
		} elseif(isset($_SESSION['user_data']['roles']['inventory']['write'])) {
			echo $vista;
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
			$roles['admin']['write']){require_once "html/top_menu.php";} 
		elseif(isset($data['roles']['inventory']['read'])&&
				$data['roles']['inventory']['read']&&
				!$data['roles']['inventory']['write']){require_once "html/top_menu_client.php";} 
		elseif(isset($data['roles']['inventory']['write'])&&
				$data['roles']['inventory']['write']&&
				$data['roles']['inventory']['read']){require_once "html/top_menu.php";}
	}

	switch ($vista) {
		case "tickets":
			$_SESSION['render']=require_once "views/vista_ticket.php"; $_SESSION['vista'] = $vista;
			break;
		case "usuarios":
			$_SESSION['render']=require_once "views/vista_usuario.php"; $_SESSION['vista'] = $vista;
			break;
		case "categorias":
			$_SESSION['render']=require_once "views/vista_categoria.php"; $_SESSION['vista'] = $vista;
			break;	
		case "carrito":
			$_SESSION['render']=require_once "views/vista_carrito.php"; $_SESSION['vista'] = $vista;
			break;
		case "factura":
			$_SESSION['render']=require_once "views/vista_factura.php"; $_SESSION['vista'] = $vista;
			break;
		case "compras":
			$_SESSION['render']=require_once "views/vista_compra.php"; $_SESSION['vista'] = $vista;
			break;
		case "historial":
			$_SESSION['render']=require_once "views/vista_historial.php"; $_SESSION['vista'] = $vista;
			break;	
		default:
			$_SESSION['render']=require_once "views/vista_cliente.php"; $_SESSION['vista'] = $vista;
			break;
	}
 

	?>
	</body>
</html>