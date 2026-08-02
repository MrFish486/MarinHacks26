<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recip"]) && isset($_POST["mesg"])) {
	$recip = escapeshellarg($_POST["recip"]);
	$mesg = escapeshellarg($_POST["mesg"]);
	$to_send = shell_exec("julia ../encryptmessage.jl $mesg $recip");
	var_dump($to_send);
}

?>
