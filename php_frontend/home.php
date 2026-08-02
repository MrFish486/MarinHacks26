<?php

session_start();

if (!isset($_SESSION["password"])) {
	header("Location: /logout.php");
	exit;
}

?>

Home!!
