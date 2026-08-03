<?php

// Local send is basically just local receive because local send is foreign send but then uhh uhhhhhhh

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$test_pass = isset($_POST["DATABLOCK"]);
	if (!$test_pass) {
		error_log("some STUPID PERSON sent me a message without correct format! FUCK THEM!");
		exit;
	}
	$pw = file_get_contents("../data/password.key");

	error_log("Using password: '" . $pw . "'");

	$d_block = $_POST["DATABLOCK"];
	
	error_log("---\nI will try to execute the following command: ");
	//error_log("julia ../decryptmessage.jl $pw $d_block");
	error_log("julia ../decryptmessage.jl $pw " . $d_block);
	error_log("---");

	//$call = shell_exec("julia ../decryptmessage.jl $pw $d_block"); // this invokation is going wrong. that's bad. this means that ... wait I KNOW WHAT'S GOING WRONG: I NEED TO USE '.' OP IN PHP
	$call = shell_exec("julia ../decryptmessage.jl $pw " . $d_block); // Ok we try this
	
	error_log("OK!! I did it!! now here's what i got:");
	error_log("---");
	error_log($call);
	error_log("---");

	if ($call != "false") {
		$cur = json_decode(file_get_contents("../data/record.json"), true);
		
		array_push($cur["msg"], ["author" => explode(" ", $call)[0], "text" => base64_decode(explode(" ", $call)[1])]);
	
		file_put_contents("../data/record.json", json_encode($cur));
	} else {
		// alr we gonna bou--BOING BOING BOIN--JESUS CHRIST SHUT UP--bounce the message to a random host in a hard-coded list of hosts that will accept the message:
		
		$hosts = ["http://localhost:8013/send.php"]; // must be exact urls
		$target = $hosts[array_rand($hosts)];
		
		$data = ["DATABLOCK" => $_POST["DATABLOCK"]];
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
		file_get_contents($target, false, $context) or error_log("UNABLE TO FORWARD MESSAGE <- THIS IS BAD!!");
	}
}
