<?php
session_start();
//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$customer_url = "index.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$logout_url = "php/logout.php";

include "html/navbar.php";
include "html/carousel.php";
include "html/home_cards.php";
?>
	</body>
</html>