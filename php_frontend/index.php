<?php

// Home page. User will enter password, which will be verified with verify.jl.

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])) {
	$pw = $_POST["password"];
	if (shell_exec("julia ../verify.jl") == "true") {
		$_SESSION["password"] = $pw;
		header("Location: index.php");
		exit;
	} else {
		$message = "Incorrect password.";
	}
}

if (isset($_SESSION["password"])) {
	header("Location: home.php");
}

?>
<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div class="centerbox">
			<div class="box">
				<h2>Please enter your password to access your inbox.</h2>
				<br type="spacer">
				<form action="/index.php" method="POST">
					<input name="password" type="password" placeholder="password">
					<button type="submit">submit</button>
				</form>
			</div>
		</div>
	</body>
</html>
