<?php

if (!isset($_SESSION["password"])) {
	header("Location: /logout.php");
	exit;
}

?>
