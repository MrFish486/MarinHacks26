<?php


session_start();

include("include/verify.php");

$mail = [];

for ($i = 0; $i < 20; $i ++) array_push($mail, "foo");

?>

<html>
	<head>
		<?php include("include/head.php"); ?>
	</head>
	<body>
		<div>
			<div class="box-ne">
				<h1>Inbox - <?= count($mail) ?> messages</h1>
				<hr></hr>
				<?php if (count($mail) == 0) { ?>
					<h2>No messages.</h2>
				<?php } else { ?>
					<?php for ($i = 0; $i < count($mail); $i ++) { ?>
						<div class="message">
							<h1>MESSAGE</h1>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="box-ne-right">
				<h1>Message</h1>
			</div>
			<div class="below-box-ne">
				<a href="/logout.php">log out</a>
			</div>
		</div>
	</body>
</html>
