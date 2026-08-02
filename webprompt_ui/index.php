<?php

$message = "";
$disp_mesg = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["password"]) && preg_match("/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$/", $_POST["password"]) && isset($_POST["ver"]) && $_POST["ver"] == $_POST["password"]) {
		$pw = escapeshellarg($_POST["password"]);
		shell_exec("julia ../createkey.jl $pw");
		shell_exec("pkill php");
		exit;
	} else {
		$message = "Please make sure your password meets the following criteria:";
		$disp_mesg = true;
	}
	if (!isset($_POST["password"]) || !isset($_POST["ver"])) {
		$message = "You must enter your password twice";
		$disp_mesg = true;
	}
	if ($_POST["password"] != $_POST["ver"]) {
		$message = "You must enter your password twice";
		$disp_mesg = true;
	}
	$pw = $_POST["password"];
	$vr = $_POST["ver"];
	error_log("pw = $pw, vr = $vr");
}

?>

<html>
	<head>
		<link rel="stylesheet" href="/css/pal.css">
		<link rel="stylesheet" href="/css/index.css">
		<link rel="favicon" href="/images/icon.png">
	</head>
	<body>
		<div class="centerbox">
			<div class="box">
				<h2><?= $disp_mesg ? $message : "Please create a password." ?></h2>
				<a>Your password must contain:</a>
				<ul>
					<li>exactly 8 characters</li>
					<li>exactly 2 uppercase characters</li>
					<li>exactly 1 special character</li>
					<li>exactly 2 numerals</li>
					<li>exactly 3 lowecase characters</li>
				</ul>
				<br type="spacer">
				<form action="/index.php" method="POST">
					<input name="password" type="password" placeholder="password"><br><br>
					<input name="ver" type="password" placeholder="verify - type again"><br><br>
					<button type="submit">submit</button>
				</form>
			</div>
		</div>
	</body>
</html>
