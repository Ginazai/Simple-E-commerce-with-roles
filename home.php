<?php
session_start();
//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$logo="html/assets/images/icons/icon.png";
$customer_url = "index.php";
$ticket_url = "actions/create/crear_ticket.php";
$user_url = "actions/create/crear_usuario.php";
$category_url = "actions/create/crear_categoria.php";
$logout_url = "actions/logout.php";

include "html/navbar.php";
include "html/carousel.php";
include "html/home_cards.php";
?>
	</body>
</html>