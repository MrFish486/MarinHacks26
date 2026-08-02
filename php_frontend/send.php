<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recip"]) && isset($_POST["mesg"])) {
	$recip = escapeshellarg($_POST["recip"]);
	$mesg = escapeshellarg($_POST["mesg"]);
	$to_send = shell_exec("julia ../encryptmessage.jl $mesg $recip");
	var_dump($to_send);
	echo "sending to myself cuz thats THATS HOW IT WORKS OK";
	
	$o_ar = explode(" ", $to_send);
	
	// ok, so now we can access the variables for final transmission (will send through loopback to php_tele server)
	
	$checksum = base64_decode($o_ar[0]);
	$enccheck = base64_decode($o_ar[1]);
	$mesgbody = base64_decode($o_ar[2]);
	
	
}

?>
