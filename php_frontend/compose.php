<?php


session_start();

include("include/verify.php");

$mail = [];

$file_content = file_get_contents("../data/record.json");
$mail = json_decode($file_content, true)["msg"];


?>

<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div>
			<div class="box-ne">
				<h1>Compose message</h1>
				<form action="send.php" method="POST">
					<input name="recip" placeholder="recipient"></input><br><br>
					<textarea name="mesg" placeholder="message"></textarea><br><br>
					<button type="submit">send</button>
				</form>
			</div>
			<div class="below-box-ne">
				<a href="/logout.php">log out</a>
				<a href="/home.php">home</a>
			</div>
		</div>
	</body>
</html>
