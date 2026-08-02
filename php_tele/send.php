<?php

// Local send is basically just local receive because local send is foreign send but then uhh uhhhhhhh

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$test_pass = isset($_POST["CHECKSUM"]) && isset($_POST["ENCRYPTEDCHECKSUM"]) && isset($_POST["ENCRYPTEDMESSAGE"]);
	if (!$test_pass) {
		error_log("some STUPID PERSON sent me a message without correct format! FUCK THEM!");
		exit;
	}
	$pw = escapeshellarg(readfile("../data/password.key"));
	$csum = escapeshellarg($_POST["CHECKSUM"]);
	$csumenc = escapeshellarg($_POST["ENCRYPTEDCHECKSUM"]);
	$encmesg = escapeshellarg($_POST["ENCRYPTEDMESSAGE"]);
	shell_exec("julia ../decryptmessage.jl $pw $csum $csumenc $encmesg");
}
