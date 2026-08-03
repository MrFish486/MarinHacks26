<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recip"]) && isset($_POST["mesg"])) {
	$recip = escapeshellarg($_POST["recip"]);
	$mesg = escapeshellarg($_POST["mesg"]);
	$to_send = shell_exec("julia ../encryptmessage.jl $mesg $recip");
	
	// ok, so now we can access the variables for final transmission (will send through loopback to php_tele server)
	
	$data = ["DATABLOCK" => $to_send];
	$headers = ["Content-type: application/x-www-form-urlencoded"];

	$opt = [
		"http" => [
			"header" => $headers,
			"method" => "POST",
			"content" => http_build_query($data),
			"ignore_errors" => true
		]
	];
	
	$context = stream_context_create($opt);
	$response = file_get_contents("http://localhost:8013/send.php", false, $context);

	header("Location: /home.php");
	exit;
}

?>
